<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsCargoOrder;
use Illuminate\Http\Request;

class TmsCargoOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->searchTerm;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        //pagination stuff sent from front-end
        $page = $request->page;
        $newItemsPerPage = (int)$request->newItemsPerPage;

        $cargoOrders = TmsCargoOrder::query()

            // If there is a search term defined...
            ->when($searchTerm, function($query, $searchTerm) {
                $query->where('description', 'like', '%' . $searchTerm . '%');
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
             * And the url will now include this too: http://127.0.0.1:8000/cargoOrders?search=a&page=2 
             */
            ->withQueryString();

        $t = 8;
        return Inertia::render('CargoOrders/Index', [
            'dataFromCargoOrderController' => $cargoOrders,
            //text search filter
            'searchTermProp' => $searchTerm,
            //sort stuff for el-table 
            'sortColumnProp' => $sortColumn,
            'sortOrderProp' => $sortOrder,
        ]);
    }
}
