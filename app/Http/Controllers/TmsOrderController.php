<?php

namespace App\Http\Controllers;

use Artisan;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsOrder;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Traits\DataBaseFilter;
use Illuminate\Support\Facades\Auth;
use App\Services\OrderHistoryCreator;
use App\Http\Requests\TmsOrderRequest;
use App\Http\Resources\TmsOrderEditResource;
use App\Http\Resources\TmsOrderIndexResource;
use App\Http\Resources\TmsOrderIndexCollection;
use App\Services\EasyBillService;
use Illuminate\Pagination\LengthAwarePaginator;

class TmsOrderController extends Controller
{
    use DataBaseFilter;

    private OrderService $orderService;
    private OrderHistoryCreator $orderHistoryCreator;
    private EasyBillService $easyBillService;

    private string $index = 'Orders/Index';
    private string $show = 'Orders/Show';
    private string $create = 'Orders/Create';
    private string $edit = 'Orders/Edit';

    public function __construct(
        OrderService $orderService, 
        OrderHistoryCreator $orderHistoryCreator,
        EasyBillService $easyBillService
    )
    {
        $this->orderService = $orderService;
        $this->orderHistoryCreator = $orderHistoryCreator;
        $this->easyBillService = $easyBillService;
    }

    /**
     * Returns records.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $searchTerm = $request->searchTerm ?? null;
        $sortColumn = $request->sortColumn ?? "order_number";
        $sortOrder = $request->sortOrder ?? "DESC";
        $searchColumns = $request->searchIn;
        //pagination stuff sent from front-end
        $page = $request->page;
        $newItemsPerPage = $request->per_page ?? 10;

        // This below is for testing purposes. It is used to test the search functionality.
        // $searchTerm = 'Andor';//1 case
        // $searchColumns = [
        //     'order_number',//simple search, 2 case, column from orders table
        //     'pickupAddresses__company_name',//relationship search, 3 case
        //     'deliveryAddresses__company_name',//relationship search, 3 case
        // ];

        $records = $this->getRecords(
            new TmsOrder(),
            $searchTerm, 
            $sortColumn, 
            $sortOrder, 
            $newItemsPerPage,
            $searchColumns,
            [//these are the relations that we want to load with the records. Loading happens in the getRecords() function.
                'parcels',
                'forwarder',
                'orderHistories.user.roles:id,name',
                'partner',
                'contact',
                'customer.headquarter',
                'nativeOrder',
                'pamyraOrder',
                'emonsInvoice'
            ],
        );

        $records = new TmsOrderIndexCollection($records);

        // return response()->json($records);

        return Inertia::render(
            $this->index, 
            [
                'records' => $records,
                'search' => $searchTerm,
                'search_in' => $searchColumns,
                'per_page' => $newItemsPerPage,
                'order_by' => $sortColumn, // table column to order by (id, name, date, etc...)
                'order' => $sortOrder // Ascending - Descending
            ]
        );
    }

    public function show($id)
    {
        $order = TmsOrder::with(
            [
                'parcels',
                'orderAddresses',
                'forwarder',
                'orderHistories.user.roles:id,name',
                'partner',
                'contact',
                'customer.headquarter',
                'nativeOrder',
                'pamyraOrder',
                'emonsInvoice'
            ]
        )->findOrFail($id);

        //format the order with the resource
        $order = new TmsOrderIndexResource($order);

        return Inertia::render(
            $this->show,
            [
                'order' => $order,
            ]
        );
    }

    public function create(): Response
    {
        return Inertia::render($this->create);
    }

    /**
     * Stores records. 
     * Inertia automatically sends succes or error feedback to the frontend. A little explanation: 
     * here we only save the record into db. This simply triggers onSuccess event in FE component, 
     * which then displays the success message.
     */
    public function store(TmsOrderRequest $request)
    {
        //The validated method is used to get the validated data from the request.
        $newRecord = $request->validated();

        //Create a new order
        $newlyCreatedRecord = TmsOrder::create($newRecord);

        //Use lazy eager loading to load the newly created record with the relationships
        $newlyCreatedRecord->load(
            [
                'parcels',
                'orderAddresses',
                'forwarder',
                'orderHistories.user.roles:id,name',
                'partner',
                'contact',
                'customer.headquarter',
                'nativeOrder',
                'pamyraOrder',
                'emonsInvoice'
            ]
        );

        //Create a new order history about this new order creation
        $this->orderHistoryCreator->createOrderHistory(
            $newlyCreatedRecord, 
            'store',
            Auth::id(),// Get the currently authenticated user's ID
            null,//cronjob name
            null//previous state
        );

        //Call the Easybill API to create a new invoice
        $this->easyBillService->callEasyBillApi($newlyCreatedRecord);

        /**
         * @Christoph said that we need to redirect the user after a successful create to the edit 
         * page. This is what we do here, otherwise this line would not be needed.
         */
        return Inertia::location("{$newlyCreatedRecord->id}/edit");
    }

    /**
     * Edit a record.
     * 
     * Here we have a multiple level nested eager loading with only some columns selected. The
     * relationships are: this order has one customer. The customer has one headquarter address. The
     * headquarter belongs to a country.
     *  
     * Now, we want:
     * customers: only id and company_name.
     * headquarter: all columns.
     * country: only id and country_name.
     *
     * @param string $id
     * @return Response
     */
    public function edit(string $id)
    {
        //Gets the relevant data for us from db.
        $record = TmsOrder::with(
            [
                'parcels',
                'orderAddresses',
                'forwarder',
                'orderHistories.user.roles:id,name',
                'partner',
                'contact',
                'customer.headquarter',
                'nativeOrder',
                'pamyraOrder',
                'emonsInvoice'
            ]

        )->findOrFail($id);

        //format the order with the resource
        $record = new TmsOrderIndexResource($record);

        //Loads the right Vue component, and sends the necesary relevant data to it.
        return Inertia::render(
            $this->edit, 
            [
                'record' => $record,
            ]
        );
    }

    /**
     * Updates records. Inertia automatically sends succes or error feedback to the frontend.
     * It also update multiple addresses, parcels... And this part gets a bit tricky. This tricky
     * part is done in the handleHeadquarter() and handleParcel() functions.
     *
     */
    public function update(TmsOrderRequest $request, string $id): void
    {
        /**
         * The validated method is used to get the validated order data from the orderRequest.
         */
        $orderFromRequest = $request->validated();//do validation

        //Get the order from db
        $orderFromDb = TmsOrder::find($id);

        //This is commented out, because we might reuse this code later when Patrick does the FE order update create part.
        // //Handle native order (if there is one, of course)
        // $this->orderService->handleNativeOrder($orderFromRequest);
        // //Handle pamyra order (if there is one, of course)
        // $this->orderService->handlePamyraOrder($orderFromRequest);
        // //Handle parcels
        // $this->orderService->handleParcel($orderFromRequest);
        // //Handle headquarter address
        // $this->orderService->handleHeadquarter($orderFromRequest);
        // //Handle pickup address
        // $this->orderService->handlePickupAddresses($orderFromRequest);
        // //Handle delivery address
        // $this->orderService->handleDeliveryAddresses($orderFromRequest);

        //Update the order
        $orderFromDb->update($orderFromRequest);
        $updatedOrder = $orderFromDb->fresh();

        //Create a new order history about this order update
        $this->orderHistoryCreator->createOrderHistory(
            $updatedOrder,//order with the new, updated data
            'update',
            Auth::id(),// Get the currently authenticated user's ID
            null,//cronjob name
            $orderFromDb//previous state, order with the old data, for archiving
        );

        /**
         * Call the Easybill API to create a new invoice. With the new, updated order, not the old one.
         */
        $this->easyBillService->callEasyBillApi($updatedOrder);
    }

    /**
     * Deletes records.
     * 
     * @param [type] $id
     * @return void
     */
    public function destroy(string $id): void
    {
        TmsOrder::destroy($id);
    }
}
