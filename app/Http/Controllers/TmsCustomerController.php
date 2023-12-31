<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\TmsCustomer;
use App\Http\Requests\TmsCustomerRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Response;
use Illuminate\Http\Request;

class TmsCustomerController extends BaseController
{
    public function __construct()
    {
        $this->model = new TmsCustomer();
        $this->vueIndexPath = 'Customers/IndexCustomer/Index';
        $this->vueCreateEditPath = 'Customers/CreateEditCustomer/CreateEditBase';
    }

    /**
     * This is used for dynamic validation. Which happens in the parent BaseController.
     *
     * @return string
     */
    protected function getRequestClass(): string
    {
        return TmsCustomerRequest::class;
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
                //These are the possibly selectable options for the el-select in customer create or edit form.
                'selectOptions' => [
                    'customerTypes' => TmsCustomer::CUSTOMER_TYPES,
                    'invoiceDispatches' => TmsCustomer::INVOICE_DISPATCHES,
                    'invoiceShippingMethods' => TmsCustomer::INVOICE_SHIPPING_METHODS,
                    'paymentMethods' => TmsCustomer::PAYMENT_METHODS,
                ]
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
     * We have overwrittten this function from the parent, because we need here customers with
     * contact addresses.
     *
     * @param string $id
     * @return Response
     */
    public function edit(string $id): Response
    {
        $record = $this->model::with('contactAddresses')->find($id);

        return Inertia::render(
            $this->vueCreateEditPath, 
            [
                'record' => $record,
                'mode' => 'edit',
                //These are the possibly selectable options for the el-select in customer create or edit form.
                'selectOptions' => [
                    'customerTypes' => TmsCustomer::CUSTOMER_TYPES,
                    'invoiceDispatches' => TmsCustomer::INVOICE_DISPATCHES,
                    'invoiceShippingMethods' => TmsCustomer::INVOICE_SHIPPING_METHODS,
                    'paymentMethods' => TmsCustomer::PAYMENT_METHODS,
                ]
            ]
        );
    }

    public function addComment(Request $request, TmsCustomer $customer)
    {
        //comment validation
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        //Get the logged in user
        $user = auth()->user();

        //Get the current date in this format 2023-12-04 14:01:26
        $date = date('Y-m-d H:i:s');

        //Getting the currently existing comments
        $comments = $customer->comments;

        //Formating the new comment that we want to add to the existing comments
        $comments[] = [
            'user_name' => $user->name,
            'comment' => $request->comment,
            'date' => $date,
        ];

        //Updating the comments column in the customers table
        $customer->update([
            'comments' => $comments,
        ]);

        // return redirect()->route('customers.edit', ['customer' => $customer->id]);
        //redirecting the user to the edit page, where he can see the newly added comment
        // return Inertia::location("http://localhost/customers/{$customer->id}/edit");//how to simply refresh the page instead of redirecting?
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

            ->with('contactAddresses')
            
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
