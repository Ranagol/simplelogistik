<?php

namespace App\Services;

use App\Models\Address;
use App\Models\TmsAddress;
use Illuminate\Pagination\LengthAwarePaginator;

class AddressService
{
    /**
     * This is an ordinary array with numeric keys, and the values are the column names.
     * This is used for the multiple column search.
     * [ 'first_name', 'last_name']
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
     * Returns records for records list (Index.vue component)
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
        array $searchColumns = []
    ): LengthAwarePaginator
    {
        // $searchColumns = [
        //     'first_name',
        //     'last_name',
        //     'customers__first_name',
        //      'customers__last_name',
        //     'forwarders__company_name',
        // ];

        //Separate simple and relationship search columns into two arrays
        $this->handleSearchColumns($searchColumns);
        
        //Define the static part of the query, but do not execute it yet.
        $query = TmsAddress::query()
        
            /**
             * SORTING
             * When there is $sortColumn and $sortOrder defined
             */
            ->when($sortColumn, function($query, $sortColumn) use ($sortOrder) {
                $query->orderBy($sortColumn, $sortOrder);
            }, function ($query) {

                //... but if sort is not specified, please return sort by id and ascending.
                return $query->orderBy('id', 'desc');
            });

        //Add dynamically more search columns to the query
        if ($searchTerm) {

            /**
             * 1 - DYNAMIC SEARCH - SIMPLE SEARCH INSIDE THE MODEL'S OWN TABLE
             */
            $query->where(function($query) use ($searchTerm) {//This adds a WHERE clause to the query.

                foreach ($this->simpleSearchColumns as $column) {//For every column in the array...
                    $query->orWhere($column, 'LIKE', "%$searchTerm%");//add an OR WHERE clause to the query.
                }
            });

            /**
             * 2 - DYNAMIC SEARCH - RELATIONSHIP SEARCH INSIDE RELATED TABLES
             * This is a more complex search, because we have to search in related tables.
             * We have to use orWhereHas() method to search in related tables.
             */
            foreach ($this->relationshipSearchColumns as $tableName => $column) {

                $query->orWhereHas($tableName, function($query) use ($searchTerm, $column) {
                    $query->where($column, 'LIKE', "%$searchTerm%");
                });
            }
            //TODO ANDOR. The dynamic search works, but only if the FE provides the
            //exact relationship name, and not table name.
        }
            
        /**
         * Include the query string too into pagination data links for page 1,2,3,4... 
         * And the url will now include this too: http://127.0.0.1:8000/users?search=a&page=2 
         */
        $records = $query->paginate($newItemsPerPage ? $newItemsPerPage : 20)->withQueryString();

        return $records;
    }

    /**
     * Separates simple search in the models own table (Example we search for street in the Address 
     * table). And the more complex search in related tables (Example we search for first_name in the
     * Customers table, on a customer that is related to the Address.).
     * $this->simpleSearchColumns - will store the simple search columns
     * $this->relationshipSearchColumns - will store the relationship search columns
     *
     * @param array $searchColumns
     * @return void
     */
    private function handleSearchColumns(array $searchColumns): void
    {
        if (empty($searchColumns)) {
            return;
        }

        /**
         * Loop through the array and separate the simple and relationship search columns. If the 
         * column has one underscore, it is a simple search column. If it has more than one, it is a
         * relationship search column.
         */
        foreach ($searchColumns as $column) {
            if (substr_count($column, '_') === 1) {
                $this->simpleSearchColumns[] = $column;
            } else {
                $result = explode('__', $column);
                $column = $result[1];
                $tableName = $result[0];

                $this->relationshipSearchColumns[$tableName] = $column;
            }
        }

        // dd($this->simpleSearchColumns, $this->relationshipSearchColumns);
    }
}

