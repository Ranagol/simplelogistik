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
use Illuminate\Pagination\LengthAwarePaginator;

class TmsOrderController extends Controller
{
    use DataBaseFilter;

    private OrderService $orderService;
    private OrderHistoryCreator $orderHistoryCreator;

    private string $index = 'Orders/Index';
    private string $show = 'Orders/Show';
    private string $create = 'Orders/Create';
    private string $edit = 'Orders/Edit';

    public function __construct(OrderService $orderService, OrderHistoryCreator $orderHistoryCreator)
    {
        $this->orderService = $orderService;
        $this->orderHistoryCreator = $orderHistoryCreator;
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
    // public function store(TmsOrderRequest $request)
    public function store()
    {
        //The validated method is used to get the validated data from the request.
        // $newRecord = $request->validated();

        $newRecord = [
            'customer_id' => 1,
            'contact_id' => 1,
            'partner_id' => null,
            'forwarder_id' => 1,
            'order_status_id' => 3,
            'order_number' => 499015,
            'owner' => null,
            'invoice_number' => null,
            'type_of_transport' => 'Parcel up to 31.5 kg',
            'origin' => 'native_sales',
            'customer_reference' => '3472348',
            'import_file_name' => null,
            'provision' => 0.01,
            'order_edited_events' => null,
            'currency' => 'EUR',
            'order_date' => '1976-01-27',
            'purchase_price' => '693.37',
            'month_and_year' => '2008-07-10 05:53:49',
            'payment_method' => null,
            'easy_bill_customer_id' => null,
            'billing_address_id' => null,
            'shipping_label_pdf' => 'http://harris.org/',
        ];

        //Create a new order
        $newlyCreatedRecord = TmsOrder::create($newRecord);

        //Use lazy eager loading to load the newly created record with the relationships
        $newlyCreatedRecord->load(
            [
                'parcels',//talk to C., which relatinship do we need on previous_state column in tms_order_histories
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
            // Get the currently authenticated user's ID
            Auth::id(),
            null
        );

        //Call the Easybill API to create a new invoice
        // $this->orderService->callEasyBillApi($newlyCreatedRecord);

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

        //Handle native order (if there is one, of course)
        $this->orderService->handleNativeOrder($orderFromRequest);

        //Handle pamyra order (if there is one, of course)
        $this->orderService->handlePamyraOrder($orderFromRequest);
        
        //Handle parcels
        $this->orderService->handleParcel($orderFromRequest);

        //Handle headquarter address
        $this->orderService->handleHeadquarter($orderFromRequest);

        //Handle pickup address
        $this->orderService->handlePickupAddresses($orderFromRequest);

        //Handle delivery address
        $this->orderService->handleDeliveryAddresses($orderFromRequest);

        //Update the order
        $orderFromDb->update($orderFromRequest);

        /**
         * Call the Easybill API to create a new invoice.
         */
        $this->orderService->callEasyBillApi($orderFromDb);
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
