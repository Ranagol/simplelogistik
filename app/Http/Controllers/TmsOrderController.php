<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsParcel;
use App\Models\TmsAddress;
use App\Models\TmsCountry;
use Illuminate\Http\Request;
use App\Models\TmsOrder;
use App\Http\Requests\TmsParcelRequest;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\TmsOrderRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class TmsOrderController extends BaseController
{


    public function __construct()
    {
        $this->model = new TmsOrder();
        $this->vueIndexPath = 'Orders/IndexOrder/Index';
        $this->vueCreateEditPath = 'Orders/CreateEditOrder/CreateEditBase';
    }

    /**
     * This is used for dynamic validation. Which happens in the parent BaseController.
     *
     * @return string
     */
    protected function getRequestClass(): string
    {
        return TmsOrderRequest::class;
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
        
        $records = $this->getRecords($searchTerm, $sortColumn, $sortOrder, $newItemsPerPage);

        return Inertia::render(
            $this->vueIndexPath, 
            [
                'dataFromController' => $records,
                'searchTermProp' => $searchTerm,
                'sortColumnProp' => $sortColumn,
                'sortOrderProp' => $sortOrder,
            ]
        );
    }

    public function create(): Response
    {
        return Inertia::render(
            $this->vueCreateEditPath, 
            [
                // 'record' => $record,
                'mode' => 'create',
            ]
        );
    }

    /**
     * Stores records. Inertia automatically sends succes or error feedback to the frontend.
     * 
     * A little explanation: here we only save the record into db.
     * This simply triggers onSuccess event in FE component, which then displays the success message
     * to the user, and then the FE component calls the $this->index() method, which returns the records.
     * So, the user gets his feedback, and the record list is refreshed.
     *
     */
    public function store()
    {
        /**
         * This is a bit tricky. How to use here dynamic validation, depending which controller is 
         * calling this method?
         * In this code, app($this->getRequestClass()) will return an instance of TmsCustomerRequest 
         * when called from TmsCustomerController.
         * So basically, here we trigger TmsCustomerRequest. The $request is an instance of
         * TmsCustomerRequest.
         */
        $request = app($this->getRequestClass());
        
        /**
         * The validated method is used to get the validated data from the request.
         */
        $newRecord = $request->validated();//do validation
        // dd($newRecord);
        /**
         * 1. Find the relevant record and...
         * 2. ...update it.
         * 3. Get the newly created record, and return it to the FE.
         */
        $newlyCreatedRecord = $this->model->create($newRecord);

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
                'startAddress.country:id,country_name', //TODO is this wrong? Should I get the addresses through the customer?
                'targetAddress.country:id,country_name',

                //1. level of eager loading (customer with id and company_name)
                'customer' => function ($query){
                    $query->select('id', 'company_name')
                            ->with(
                                [

                                    //2. level of eager loading (headquarter with all columns)
                                    'headquarter' => function ($query){
                                        $query->with(

                                            //3. level of eager loading (country with id and country_name)
                                            ['country:id,country_name']
                                        );
                                    }
                                ]);
                }

            ]
        )->find($id);
        
        //Loads the right Vue component, and sends the necesary relevant data to it.
        return Inertia::render(
            $this->vueCreateEditPath, 
            [
                'record' => $record,
                'mode' => 'edit',
                //This is data for the select/options fields in the form, so the user can choose.
                'selectOptions' => [
                    'countries' => TmsCountry::select('id', 'country_name')->get(),
                    'typesOfTransport' => TmsOrder::TYPES_OF_TRANSPORT,
                    'origins' => TmsOrder::ORIGINS,//Example: Pamyra, sales...
                    'paymentMethods' => TmsOrder::PAYMENT_METHODS,
                    'parcelTypes' => TmsParcel::PARCEL_TYPE,
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
    public function update(string $id): void
    {
        /**
         * We get the $request on this awkward way, so this function is compatible with the parent
         * update() function. Otherwise, we could just simply inject the TmsOrderRequest
         * into this function. Which would be much cleaner.
         */
        $orderRequest = app(TmsOrderRequest::class);

        /**
         * The validated method is used to get the validated order data from the orderRequest.
         */
        $orderFromRequest = $orderRequest->validated();//do validation

        //Get the order from db
        $orderFromDb = TmsOrder::find($id);
        
        //Handle parcels
        $this->handleParcel($orderFromRequest);

        //Handle headquarter address
        $this->handleHeadquarter($orderFromRequest);
        //TODO ANDOR: I stopped here. The current problem: the addressType mutator does not triggers
        //when we do upsert. So, the address_type column is not filled with the correct value. Because
        //in the db, in address_type column, the app tries to write "headquarter", instead of
        //number 1 (which is the correct value for headquarter address type). 
        //What to do: check the data type: Ensure that the addressType attribute is being treated as a string in your TmsAddress model. The mutator expects the addressType value to be a string, so if it's being treated as a different data type, the mutator might not work correctly.

        //Update the order
        $orderFromDb->update($orderFromRequest);
    }

    private function handleHeadquarter(array $orderFromRequest): void
    {

        /**
         * If the order has a headquarter address... Do create or update for the headquarter address,
         * depending if the headquarter address already exists in the db or not. This will be 
         * recognised by the id column.
         */
        if (!empty($orderFromRequest['customer']['headquarter'])) {

            $headquarter = $orderFromRequest['customer']['headquarter'];
            // dd($headquarter);

            TmsAddress::upsert(
                //1-An array of records that should be updated or created.
                [
                    $headquarter//only one headquarter address exists for one customer
                ],
                //2-The column(s) that should be used to determine if a record already exists.
                'id',
                //3-The column(s) that should be updated if a matching record already exists.
                [
                    "company_name",
                    "first_name",
                    "last_name",
                    "address_type",
                    "street",
                    "house_number",
                    "zip_code",
                    "city",
                    "state",
                    "phone",
                    "email",
                    "address_additional_information",
                    "country_id",
                    "customer_id",
                    "forwarder_id",
                    "created_at",
                    "updated_at",
                ]
            );
        }
    }

    private function handleParcel(array $orderFromRequest): void
    {

        /**
         * If the order has parcels... Do create or update for each parcel, depending if the parcel
         * already exists in the db or not. This will be recognised by the id column.
         */
        if (!empty($orderFromRequest['parcels'])) {

        $parcels = $orderFromRequest['parcels'];


            TmsParcel::upsert(
                //1-An array of records that should be updated or created.
                $parcels,
                //2-The column(s) that should be used to determine if a record already exists.
                'id',
                //3-The column(s) that should be updated if a matching record already exists.
                [
                    "is_hazardous",
                    "information",
                    "p_name",
                    "p_height",
                    "p_length",
                    "p_width",
                    "p_number",
                    "p_stackable",
                    "p_weight",
                ]
            );
        }
    }

    /**
     * Returns records for records list (Index.vue component). The only reason why we use this
     * function here and not the one inherited from the parent is the 
     * ->with('contactAddresses')
     * line. We must return customers with contact addresses.
     *
     * @param string|null $searchTerm
     * @param string|null $sortColumn
     * @param string|null $sortOrder
     * @param integer|null $newItemsPerPage
     * @return LengthAwarePaginator
     */
    private function getRecords(
        string $searchTerm = null, 
        string $sortColumn = null, 
        string $sortOrder = null, 
        int $newItemsPerPage = null,
    ): LengthAwarePaginator
    {
        $records = $this->model::query()

            // If there is a search term defined...
            ->when($searchTerm, function($query, $searchTerm) {

                /**
                 * This is a bit tricky.
                 * Here we use a model scope. The model scope code is defined in the relevant model.
                 * https://laravel.com/docs/10.x/eloquent#local-scopes
                 */
                $query->searchBySearchTerm($searchTerm);
            })
            
            /**
             * SORTING
             * When there is $sortColumn and $sortOrder defined
             */
            ->when($sortColumn, function($query, $sortColumn) use ($sortOrder) {
                $query->orderBy($sortColumn, $sortOrder);
            }, function ($query) {

                //... but if sort is not specified, please return sort by id and ascending.
                return $query->orderBy('id', 'desc');
            })

            //we need these relationships. Not all columns, only the selected ones.
            ->with([
                'startAddress:id,city,country_id,first_name,last_name', 
                'targetAddress:id,city,country_id,first_name,last_name',
                'parcels'
            ])
            
            /**
             * PAGINATION
             * If it is not otherwise specified, paginate by 10 items per page.
             */
            ->paginate($newItemsPerPage ? $newItemsPerPage : 10)

            /**
             * Include the query string too into pagination data links for page 1,2,3,4... 
             * And the url will now include this too: http://127.0.0.1:8000/users?search=a&page=2 
             */
            ->withQueryString();

        return $records;
    }
}

