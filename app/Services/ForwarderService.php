<?php

namespace App\Services;

use App\Models\TmsForwarder;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * This class contains helper methods for the TmsForwarderController.
 */
class ForwarderService
{
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
    public function getRecords(
        string $searchTerm = null, 
        string $sortColumn = null, 
        string $sortOrder = null, 
        int $newItemsPerPage = null,
    ): LengthAwarePaginator
    {
        $records = TmsForwarder::query()

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

                //... but if sort is not specified, please return sort by id and descending.
                return $query->orderBy('id', 'desc');
            })

            //we need these relationships. Not all columns, only the selected ones.
            ->with([
                
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