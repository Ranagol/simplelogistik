<?php

namespace App\Http\Controllers;

use Artisan;
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
use App\Traits\DataBaseFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TmsOrderController extends Controller
{
    use DataBaseFilter;

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
        $searchTerm = $request->searchTerm ?? null;
        $sortColumn = $request->sortColumn ?? "order_date";
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
                'orderAddresses',
                'pickupAddresses',
                'deliveryAddresses',
                'forwarder',
                'orderHistories.user.roles:id,name',
                'partner',
                'contact',
                'customer.headquarter',
                'nativeOrder',
                'pamyraOrder',
            ],
        );

        $records = new TmsOrderIndexCollection($records);


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
         * Call the Esaybill API to create a new invoice.
         */
        $id = $newlyCreatedRecord->id;
        $result = Artisan::command('Easybill.sendinvoices', function($id) {
            echo $id;   
        });
        file_put_contents('test.txt', Artisan::output());
        /**
         * Todo: 
         * - check if the API call was successful.
         * - store result in session.
         * - display result in FE.
         */


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

        /**
         * Call the Esaybill API to create a new invoice.
         */
        $id = $orderFromDb->id;
        // $result = Artisan::command('Easybill.sendinvoices ', function($id) {
        //     echo $id;   
        // });
        $result = $this->execute('cd ..; php artisan sendinvoices ' . $id . ';');
        file_put_contents('test.txt', $result);
        /**
         * Todo: 
         * - check if the API call was successful.
         * - store result in session.
         * - display result in FE.
         */
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


    public static function execute($cmd): string
    {
        $process = Process::fromShellCommandline($cmd);

        $processOutput = '';

        $captureOutput = function ($type, $line) use (&$processOutput) {
            $processOutput .= $line;
        };

        $process->setTimeout(null)
            ->run($captureOutput);

        if ($process->getExitCode()) {
            $exception = new \Exception($cmd . " - " . $processOutput);
            report($exception);

            throw $exception;
        }

        return $processOutput;
    }

}
