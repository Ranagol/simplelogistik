<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsOrder;
use App\Models\TmsParcel;
use App\Models\TmsAddress;
use App\Models\TmsCountry;
use App\Models\TmsCustomer;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Requests\TmsOrderRequest;
use App\Http\Requests\TmsParcelRequest;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TmsOrderCollection;
use App\Http\Resources\TmsOrderEditResource;
use App\Http\Resources\TmsOrderIndexResource;
use App\Http\Resources\TmsOrderIndexCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TmsOrderController extends Controller
{
    private $orderService;

    private string $index = 'Orders/Index';
    private string $show = 'Orders/Show';
    private string $create = 'Orders/Create';
    private string $edit = 'Orders/Edit';

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Returns records.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $searchTerm = $request->searchTerm;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        //pagination stuff sent from front-end
        $page = $request->page;
        $newItemsPerPage = (int)$request->newItemsPerPage;

        $records = $this->orderService->getRecords(
            $searchTerm, 
            $sortColumn, 
            $sortOrder, 
            $newItemsPerPage
        );

        return Inertia::render(
            $this->index, 
            [
                'dataFromController' => $records,
                'searchTermProp' => $searchTerm,
                'sortColumnProp' => $sortColumn,
                'sortOrderProp' => $sortOrder,
            ]
        );
    }

    public function show($id): Response
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
            ]
        )->findOrFail($id);

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
     * Stores records. Inertia automatically sends succes or error feedback to the frontend.
     * 
     * A little explanation: here we only save the record into db.
     * This simply triggers onSuccess event in FE component, which then displays the success message
     */
    public function store(TmsOrderRequest $request)
    {
        
        /**
         * The validated method is used to get the validated data from the request.
         */
        $newRecord = $request->validated();//do validation

        $newlyCreatedRecord = TmsOrder::create($newRecord);

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
    public function edit(string $id): Response
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
            ]

        )->findOrFail($id);
        
        //Change response data structure according to FE needs.
        $record = new TmsOrderEditResource($record);

        //Loads the right Vue component, and sends the necesary relevant data to it.
        return Inertia::render(
            $this->edit, 
            [
                'record' => $record,

                //This is data for the select/options fields in the form, so the user can choose.
                'selectOptions' => [
                    'countries' => TmsCountry::select('id', 'country_name')->get(),
                    'typesOfTransport' => TmsOrder::TYPES_OF_TRANSPORT,
                    'origins' => TmsOrder::ORIGINS,//Example: Pamyra, sales...
                    // 'paymentMethods' => TmsCustomer::PAYMENT_METHODS,
                    'parcelTypes' => TmsParcel::PARCEL_TYPE,
                    // 'statuses' => TmsOrder::STATUSES,//Example: 'Order created', 'Order confirmed'...
                ]
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
