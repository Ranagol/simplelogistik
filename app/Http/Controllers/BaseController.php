<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\TmsCustomerRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Http\FormRequest;


abstract class BaseController extends Controller
{
    protected Model $model;
    protected string $modelName;
    protected string $vueIndexPath;
    protected string $vueCreateEditPath;

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

    public function show(string $id): void
    {
        $record = $this->model::find($id);
    }

    public function create()
    {
        return Inertia::render(
            $this->vueCreateEditPath, 
            [
                'mode' => 'create'
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
     * @return void
     */
    public function store(): void
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
         */
        $this->model->create($newRecord);
    }

    public function edit(string $id): Response
    {
        $record = $this->model::find($id);
        return Inertia::render(
            $this->vueCreateEditPath, 
            [
                'record' => $record,
                'mode' => 'edit'
            ]
        );
    }

    /**
     * Updates records. Inertia automatically sends succes or error feedback to the frontend.
     *
     * @param string $id
     * @return void
     */
    public function update(string $id): void
    {
        /**
         * This is a bit tricky. How to use here dynamic validation, depending which controller is 
         * calling this method?
         * In this code, app($this->getRequestClass()) will return an instance of TmsCustomerRequest 
         * when called from TmsCustomerController.
         * So basically, here we trigger TmsCustomerRequest. The $request is an instance of
         * TmsCustomerRequest.
         */
        $request = app($this->getRequestClass());//Here I am getting this error: Method Illuminate\Validation\Validator::validateUnsigned does not exist.
        
        /**
         * The validated method is used to get the validated data from the request.
         */
        $newRecord = $request->validated();//do validation
        // dd($newRecord);

        /**
         * 1. Find the relevant record and...
         * 2. ...update it.
         */
        $this->model->find($id)->update($newRecord);
    }

    /**
     * Deletes records. This triggers the onSuccess event in FE component, which then displays
     * the success message to the user, and then the FE component calls the $this->index() method,
     * which returns the records. So, the user gets his feedback, and the record list is refreshed.
     * 
     * @param [type] $id
     * @return void
     */
    public function destroy(Request $request, string $id): void
    {
        $this->model::destroy($id);
    }

    /**
     * Deletes multiple records at the same time.
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
        $ids = $request->ids;
        // dd($ids);
        $this->model::destroy($ids);
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

    protected function getRequestClass()
    {
        return Request::class; // Default to the base request class
    }
}
