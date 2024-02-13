<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * This trait is used for the majority of all index() functions in the controllers. It is used for
 * the records list (Index.vue component). It is used for the search, sort and pagination of the
 * records. Since these are repeated functions, we extracted it here.
 */
trait DataBaseFilter {

    /**
     * This is an ordinary array with numeric keys, and the values are the column names.
     * This is used for the multiple column search. [ 'first_name', 'last_name']
     *
     * @var array
     */
    private array $simpleSearchColumns = [];

    /**
     * This is an asoc. array. The key is the related table name, and the value is the column name.
     * [ 'customers' => 'first_name', 'customers' => 'last_name', 'forwarders' => 'company_name']
     *
     * @var array
     */
    private array $relationshipSearchColumns = [];

    /**
     * Returns records for records list (Index.vue component). This is the main function that
     * triggers all other functions from this class.
     *
     * @param string|null $searchTerm
     * @param string|null $sortColumn
     * @param string|null $sortOrder
     * @param integer|null $newItemsPerPage
     * @param array $searchColumns
     * @return LengthAwarePaginator
     */
    public function getRecords(
        Model $model,
        string $searchTerm = null, 
        string $sortColumn = null, 
        string $sortOrder = null, 
        int $newItemsPerPage = null,
        array $searchColumns = null,
        array $relations = []
    ): LengthAwarePaginator
    {

        //Separate simple and relationship search columns into two arrays
        $this->handleSearchColumns($searchColumns);
        
        //Make the dynamic query
        $query = $this->makeDynamicQuery(
            $model,
            $searchTerm, 
            $sortColumn, 
            $sortOrder, 
        );
            
        /**
         * Do pagination.
         * Include the query string too into pagination data links for page 1,2,3,4... 
         * And the url will now include this too: http://127.0.0.1:8000/users?search=a&page=2 
         */

        $records = $query->with($withRelations)->paginate($newItemsPerPage ?? 10)->withQueryString();
        return $records;
    }

    /**
     * Separates simple search in the models own table (Example we search for street in the ...Model 
     * table). And the more complex search in related tables (Example we search for first_name in the
     * Customers table, on a customer that is related to the ...Model.).
     * $this->simpleSearchColumns - will store the simple search columns
     * $this->relationshipSearchColumns - will store the relationship search columns
     *
     * @param array $searchColumns
     * @return void
     */
    private function handleSearchColumns(array $searchColumns)
    {
        if (empty($searchColumns)) {
            return;
        }

        /**
         * Loop through the array and separate the simple and relationship search columns. If the 
         * column has two underscores like __, it is a
         * relationship search column. Example: customers__first_name. Else it is a simple search.
         * Example: first_name.
         */
        foreach ($searchColumns as $column) {
            if (substr_count($column, '__') === 1) {
                $result = explode('__', $column);
                $column = $result[1];
                $relationshipName = $result[0];
                $this->relationshipSearchColumns[$relationshipName] = $column;
            } elseif (substr_count($column, '__') > 1) {
                throw new \Exception('You can not have more than one "__" in the column name.');
                Log::error('You can not have more than one "__" in the column name.');
            } else {
                $this->simpleSearchColumns[] = $column;
            }
        }
    }

    /**
     * Creates a dynamic query based on the search term, sort column and sort order, and the
     * search columns (this latter is data in which related tables in which columns should we also
     * search.)
     *
     * @param string $searchTerm
     * @param string|null $sortColumn
     * @param string|null $sortOrder
     * @return Builder
     */
    private function makeDynamicQuery(
        Model $model,
        string | null $searchTerm, 
        string | null $sortColumn,
        string | null $sortOrder,  
    ): Builder
    {
        //Define the static part of the query, but do not execute it yet.
        $query = $model::query();

        //Add dynamically more search columns to the query, if there is a search term
        if ($searchTerm && !is_null($searchTerm)) {

            //1 - DYNAMIC SEARCH - SIMPLE SEARCH INSIDE THE MODEL'S OWN TABLE
            $this->searchSimple($query, $searchTerm);

            //2 - DYNAMIC SEARCH - RELATIONSHIP SEARCH INSIDE RELATED TABLES
            foreach ($this->relationshipSearchColumns as $relationshipName => $columnInRelatiodTable) {
                $this->searchThroughRelationship(
                    $query, 
                    $searchTerm, 
                    $columnInRelatiodTable, 
                    $relationshipName
                );
            }
        }

        /**
         * SORTING
         */
        $query->when($sortColumn, function($query, $sortColumn) use ($sortOrder) {
            $query->orderBy($sortColumn, $sortOrder);
        }, function ($query) {

            //... but if sort is not specified, please return sort by id and ascending.
            return $query->orderBy('id', 'desc');
        });

        return $query;
    }
    
    /**
     * 1 - DYNAMIC SEARCH - SIMPLE SEARCH INSIDE THE MODEL'S OWN TABLE
     *
     * @param Builder $query
     * @param string $searchTerm
     * @return Builder
     */
    private function searchSimple(
        Builder $query, 
        string $searchTerm, 
    ): Builder
    {
        //This adds a WHERE clause to the query.
        return $query->where(function($query) use ($searchTerm) {

            //For every column name in the array...
            foreach ($this->simpleSearchColumns as $column) {

                //add an OR WHERE clause to the query.
                $query->orWhere($column, 'LIKE', "$searchTerm%");
            }
        });
    }

    /**
     * 2 - DYNAMIC SEARCH - RELATIONSHIP SEARCH INSIDE RELATED TABLES
    * This is a more complex search, because we have to search in related tables.
    * We have to use orWhereHas() method to search in related tables.
     *
     * @param Builder $query
     * @param string $searchTerm
     * @param string $columnInRelatedTable
     * @param string $relationshipName
     * @return Builder
     */
    private function searchThroughRelationship(
        Builder $query, 
        string$searchTerm, 
        string $columnInRelatedTable, 
        string $relationshipName
    ): Builder
    {
        return $query->orWhereHas($relationshipName, function($query) use ($searchTerm, $columnInRelatedTable) {
            $query->where($columnInRelatedTable, 'LIKE', "$searchTerm%");
        });
    }

}