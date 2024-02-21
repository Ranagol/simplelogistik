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
    public array $simpleSearchColumns = [];

    /**
     * This is an asoc. array. The key is the related table name, and the value is the column name.
     * [ 'customers' => 'first_name', 'customers' => 'last_name', 'forwarders' => 'company_name']
     *
     * @var array
     */
    public array $relationshipSearchColumns = [];

    /**
     * Returns records for records list (Index.vue component). This is the main function that
     * triggers all other functions from this class.
     *
     * @param Model $model
     * @param string|null $searchTerm
     * @param string|null $sortColumn
     * @param string|null $sortOrder
     * @param integer|null $newItemsPerPage
     * @param array|null $searchColumns         //['first_name', 'last_name', 'customers__first_name']
     * @param array $relationshipNames          //['customer', 'forwarder']
     * @return LengthAwarePaginator
     */
    public function getRecords(
        Model $model,
        string $searchTerm = null, 
        string $sortColumn = null, 
        string $sortOrder = null, 
        int $newItemsPerPage = null,
        array $searchColumns = null,
        array $relationshipNames = [],
    ): LengthAwarePaginator
    {

        //Separate simple and relationship search columns into two arrays
        $this->handleSearchColumns($searchTerm ?? "", $searchColumns ?? []);
        
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
        $records = $query->with($relationshipNames)->paginate($newItemsPerPage ?? 10)->withQueryString();//With Patrick adding the relationships

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
    private function handleSearchColumns(string $searchTerm = null, array $searchColumns)
    {
        //If there is no search term and no search columns, then we do not need to do anything here.
        if ( is_null($searchTerm) && empty($searchColumns)) {
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

        /**
         * 1 - SIMPLEST CASE
         * - searchterm exists
         * - no simple search columns
         * - no relationship search columns
         * - we search all columns in the model's own table with the searchterm
         */
        if ($searchTerm && empty($this->simpleSearchColumns) && empty($this->relationshipSearchColumns) ) {

            $columnsToSearch = [
                'order_number',
                'invoice_number',
                'customer_reference',
                'month_and_year',
            ];

            foreach ($columnsToSearch as $column) {
                $query->orWhere($column, 'LIKE', '%' . $searchTerm . '%');
            }
        }

        /**
         * 2 - Search in base model, but only in selected columns
         * - searchterm exists
         * - simple search columns exist
         * - no relationship search columns
         * - we search all columns in the model's own table with the searchterm
         */
        if ($searchTerm && empty($this->relationshipSearchColumns)) {

            //Simple search in the model's own table in selected columns
            foreach ($this->simpleSearchColumns as $column) {
                $query->orWhere($column, 'LIKE', $searchTerm . '%');
            }
        }

        /**
         * 3 - Search  in related tables only
         * - searchterm exists
         * - simple search columns DOES NOT exist
         * - relationship search columns exist
         */
        if ($searchTerm && empty($this->simpleSearchColumns) && !empty($this->relationshipSearchColumns)) {

            //Relationship search in related tables
            foreach ($this->relationshipSearchColumns as $relationshipName => $columnInRelatedTable) {
                $query->orWhereHas($relationshipName, function($query) use ($searchTerm, $columnInRelatedTable) {
                    $query->where($columnInRelatedTable, 'LIKE', $searchTerm . '%');
                });
            }
        }

        /**
         * 4 - Search in base model in selected columns, but also search in related tables too.
         * - searchterm exists
         * - simple search columns exist
         * - relationship search columns exist
         */
        if ($searchTerm && !empty($this->simpleSearchColumns) && !empty($this->relationshipSearchColumns)) {

            //a.) Simple search in the model's own table in selected columns
            foreach ($this->simpleSearchColumns as $column) {
                $query->orWhere($column, 'LIKE', $searchTerm . '%');
            }

            //b.) Relationship search in related tables
            foreach ($this->relationshipSearchColumns as $relationshipName => $columnInRelatedTable) {
                $query->orWhereHas($relationshipName, function($query) use ($searchTerm, $columnInRelatedTable) {
                    $query->where($columnInRelatedTable, 'LIKE', $searchTerm . '%');
                });
            }
        }

        /**
         * Add sorting to the existing query. 
         */
        $query->when($sortColumn, function($query, $sortColumn) use ($sortOrder) {
            $query->orderBy($sortColumn, $sortOrder);
        });

        return $query;
    }
}