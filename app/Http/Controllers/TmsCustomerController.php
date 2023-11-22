<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsCustomer;
use Illuminate\Http\Request;


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

        $t = 8;
        return Inertia::render('Customers/Index', [
            'dataFromCustomerController' => $customers,
            //text search filter
            'searchTermProp' => $searchTerm,
            //sort stuff for el-table 
            'sortColumnProp' => $sortColumn,
            'sortOrderProp' => $sortOrder,
        ]);
    }

    /**
     * Stores customers.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
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

        /**
         * when there is no sort column, sort order or pagination data defined by the FE component,
         * then in index() method we return sorted by id and ascending, and paginated by 10 items 
         * per page. This way we can see immediatelly the newly created customer
         */
        return Inertia::location(route('customers.index'));
    }

    public function update(Request $request, $id)
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

        /**
         * when there is no sort column, sort order or pagination data defined by the FE component,
         * then in index() method we return sorted by id and ascending, and paginated by 10 items 
         * per page. This way we can see immediatelly the newly created customer
         */
        return Inertia::location(route('customers.index'));
    }

    /**
     * Deletes customers.
     *
     * @param [type] $id
     * @return void
     */
    public function destroy(Request $request, $id)
    {
        dd($request->all());
        TmsCustomer::destroy($id);
        // return redirect()->back();//nah
        // return to_route('customers.index');//nah
        // return redirect()->route('customers.index')->with('message', 'Customer deleted successfully');
        // $this->index();
        // return redirect()->route('customers.index');
        return Inertia::location(route('customers.index'));//How to return customers with pagination data and sorting data?
        return redirect()->back()->with('error', 'There was an error deleting the customer');//Maybe this message will appear in errors?
    }

    public function customerDelete(Request $request)
    {
        // dd($request->all());
        TmsCustomer::destroy($request->id);
        // return redirect()->back();//nah
        // return to_route('customers.index');//nah
        // return redirect()->route('customers.index')->with('message', 'Customer deleted successfully');
        // $this->index();
        // return redirect()->route('customers.index');
        $searchTerm = $request->searchTerm;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        //pagination stuff sent from front-end
        $page = $request->page;
        $newItemsPerPage = (int)$request->newItemsPerPage;
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
        return Inertia::location(route('customers.index', [
            'dataFromCustomerController' => $customers,
            //text search filter
            'searchTermProp' => $searchTerm,
            //sort stuff for el-table 
            'sortColumnProp' => $sortColumn,
            'sortOrderProp' => $sortOrder,
        ]));


        //return redirect()->back()->with('error', 'There was an error deleting the customer');//TODO Maybe this message will appear in errors?
    }
}


