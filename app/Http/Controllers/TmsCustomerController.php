<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsCustomer;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TmsCustomerController extends Controller
{
    /**
     * Returns customers.
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
        $elDialogVisible = $request->elDialogVisible ?? false;

        
        $customers = $this->getCustomers($searchTerm, $sortColumn, $sortOrder, $newItemsPerPage);

        $t = 8;
        return Inertia::render('Customers/Index', [
            'dataFromController' => $customers,
            'searchTermProp' => $searchTerm,
            'sortColumnProp' => $sortColumn,
            'sortOrderProp' => $sortOrder,
            // 'elDialogVisibleProp' => $elDialogVisible,
        ]);
    }

    public function show(string $id): void
    {
        $customer = TmsCustomer::find($id);
    }

    /**
     * Stores customers. Inertia automatically sends succes or error feedback to the frontend.
     * 
     * A little explanation: here we only save the customer into db.
     * This simply triggers onSuccess event in FE component, which then displays the success message
     * to the user, and then the FE component calls the $this->index() method, which returns the customers.
     * So, the user gets his feedback, and the customer list is refreshed.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request): void
    {
        $request->validate([
            'company_name' => 'required|string|min:2|max:100',
            'name' => 'required|string|min:2|max:200',
            'email' => 'required|email|max:100',
            'rating' => 'required|integer|between:1,5',
            'tax_number' => 'required|string|min:2|max:50',
            'internal_cid' => 'required|string|min:2|max:100',
        ]);
        
        TmsCustomer::create($request->all());
    }

    /**
     * Updates customers. Inertia automatically sends succes or error feedback to the frontend.
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function update(Request $request, string $id): void
    {
        $request->validate([
            'company_name' => 'required|string|min:2|max:100',
            'name' => 'required|string|min:2|max:200',
            'email' => 'required|email|max:100',
            'rating' => 'required|integer|between:1,5',
            'tax_number' => 'required|string|min:2|max:50',
            'internal_cid' => 'required|string|min:2|max:100',
        ]);
        
        TmsCustomer::find($id)->update($request->all());
    }

    /**
     * Deletes customers. This triggers the onSuccess event in FE component, which then displays
     * the success message to the user, and then the FE component calls the $this->index() method,
     * which returns the customers. So, the user gets his feedback, and the customer list is refreshed.
     * 
     * @param [type] $id
     * @return void
     */
    public function destroy(Request $request, string $id): void
    {
        TmsCustomer::destroy($id);
    }

    /**
     * Deletes multiple customers at the same time.
     * destroy() can be used for multiple deletes too, if you send an array of ids:
     * https://laravel.com/docs/10.x/eloquent#deleting-an-existing-model-by-its-primary-key
     * Example:
     * Flight::destroy(1);
     * Flight::destroy(1, 2, 3);
     * Flight::destroy([1, 2, 3]);
     * 
     * So $id here can be an integer, or an array of integers.
     *
     * @param Request $request
     * @return void
     */
    public function batchDelete(Request $request): void
    {
        $customerIds = $request->customerIds;
        // dd($customerIds);
        TmsCustomer::destroy($customerIds);
    }

    /**
     * Returns customers.
     *
     * @param string|null $searchTerm
     * @param string|null $sortColumn
     * @param string|null $sortOrder
     * @param integer|null $newItemsPerPage
     * @return LengthAwarePaginator
     */
    private function getCustomers(
        string $searchTerm = null, 
        string $sortColumn = null, 
        string $sortOrder = null, 
        int $newItemsPerPage = null,
    ): LengthAwarePaginator
    {
        $customers = TmsCustomer::query()

            // If there is a search term defined...
            ->when($searchTerm, function($query, $searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%');
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

            // dd($customers);
        return $customers;
    }
}
