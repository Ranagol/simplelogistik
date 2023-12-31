<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsAddress;
use App\Models\TmsCustomer;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\TmsAddressRequest;
use App\Models\TmsCountry;
use App\Models\TmsForwarder;
use Illuminate\Pagination\LengthAwarePaginator;

class TmsAddressController extends BaseController
{
    public function __construct()
    {
        $this->model = new TmsAddress();
        $this->vueIndexPath = 'Addresses/IndexAddress/Index';
        $this->vueCreateEditPath = 'Addresses/CreateEditAddress/CreateEditBase';
    }

    /**
     * This is used for dynamic validation. Which happens in the parent BaseController.
     *
     * @return string
     */
    protected function getRequestClass(): string
    {
        return TmsAddressRequest::class;
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
                'addressTypes' => TmsAddress::ADDRESS_TYPES,
                // we send all customers and forwarders to the FE, so that the user can select them
                'customers' => TmsCustomer::all()->map(function ($customer) {
                    return [
                        'id' => $customer->id,
                        'name' => $this->generateCustomerName($customer),
                    ];
                }),
                'forwarders' => TmsForwarder::all()->map(function ($forwarder) {
                    return [
                        'id' => $forwarder->id,
                        'name' => $forwarder->company_name,
                    ];
                }),

            ]
        );
    }

    /**
     * If this is a company return the company name, otherwise return the name of the person.
     * This name will be created from the first and last name.
     *
     * @return string
     */
    private function generateCustomerName(TmsCustomer $customer): string
    {
        if ($customer->company_name) {
            return $customer->company_name;
        }

        return $customer->first_name . ' ' . $customer->last_name;
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
        $request = app($this->getRequestClass());//


        
        
        /**
         * The validated method is used to get the validated data from the request.
         */
        $newRecord = $request->validated();//do validation

        /**
         * 1. Find the relevant record and...
         * 2. ...update it.
         * 3. Get the newly created record, and return it to the FE.
         */
        $newlyCreatedRecord = $this->model->create($newRecord);

        /**
         * @Christoph said that we need to redirect the user after a successful create to the edit 
         * page.
         */
        return Inertia::location("{$newlyCreatedRecord->id}/edit");
    }

    /**
     * Undocumented function
     *
     * @param string $id
     * @return Response
     */
    public function edit(string $id): Response
    {
        $record = $this->model::with('country:id,country_name')->find($id);

        return Inertia::render(
            $this->vueCreateEditPath, 
            [
                'record' => $record,
                'mode' => 'edit',
                'addressTypes' => TmsAddress::ADDRESS_TYPES,
                
                /**
                 * We send all customers and forwarders to the FE, so that the user can select them
                 * in an el-select. Because every address must belong to a customer and a forwarder.
                 */
                'customers' => TmsCustomer::all()->map(function ($customer) {
                    return [
                        'id' => $customer->id,
                        'name' => $this->generateCustomerName($customer),
                    ];
                }),
                'forwarders' => TmsForwarder::all()->map(function ($forwarder) {
                    return [
                        'id' => $forwarder->id,
                        'name' => $forwarder->company_name,
                    ];
                }),
                //we send countries to the FE, so that the user can select them in el-select
                'countries' => TmsCountry::all()->map(function ($country) {
                    return [
                        'id' => $country->id,
                        'country_name' => $country->country_name,
                    ];
                }),
            ]
        );
    }

    /**
     * Returns records for records list (Index.vue component)
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

            ->with('country')
            
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

            // dd($records);
        return $records;
    }
}


  