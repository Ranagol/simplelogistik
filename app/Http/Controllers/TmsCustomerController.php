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
                return $query->orderBy('id', 'asc');
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

        return redirect()->back();
    }

    /**
     * Deletes customers.
     *
     * @param [type] $id
     * @return void
     */
    public function destroy($id)
    {
        TmsCustomer::destroy($id);
        // return redirect()->back();
        // return to_route('customers.index');
        return redirect()->route('customers.index')->with('message', 'Customer deleted successfully');
    }
}


