<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsGear;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\TmsGearRequest;

class TmsGearController extends Controller
{
     /**
     * Returns requirements.
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
        
        $requirements = $this->getRequirements($searchTerm, $sortColumn, $sortOrder, $newItemsPerPage);

        return Inertia::render('Requirements/Index', [
            'dataFromController' => $requirements,
            'searchTermProp' => $searchTerm,
            'sortColumnProp' => $sortColumn,
            'sortOrderProp' => $sortOrder,
        ]);
    }

    public function show(string $id): void
    {
        $vehicle = TmsGear::find($id);
    }

    /**
     * Stores requirements. Inertia automatically sends succes or error feedback to the frontend.
     * 
     * A little explanation: here we only save the vehicle into db.
     * This simply triggers onSuccess event in FE component, which then displays the success message
     * to the user, and then the FE component calls the $this->index() method, which returns the requirements.
     * So, the user gets his feedback, and the vehicle list is refreshed.
     *
     * @param TmsGearRequest $request
     * @return void
     */
    public function store(TmsGearRequest $request): void
    {
        TmsGear::create($request->all());
    }

    /**
     * Updates requirements. Inertia automatically sends succes or error feedback to the frontend.
     *
     * @param TmsGearRequest $request
     * @param [type] $id
     * @return void
     */
    public function update(TmsGearRequest $request, string $id): void
    {
        TmsGear::find($id)->update($request->all());
    }

    /**
     * Deletes requirements. This triggers the onSuccess event in FE component, which then displays
     * the success message to the user, and then the FE component calls the $this->index() method,
     * which returns the requirements. So, the user gets his feedback, and the vehicle list is refreshed.
     * 
     * @param [type] $id
     * @return void
     */
    public function destroy(Request $request, string $id): void
    {
        TmsGear::destroy($id);
    }

    /**
     * Deletes multiple requirements at the same time.
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
        TmsGear::destroy($ids);
    }

    /**
     * Returns requirements.
     *
     * @param string|null $searchTerm
     * @param string|null $sortColumn
     * @param string|null $sortOrder
     * @param integer|null $newItemsPerPage
     * @return LengthAwarePaginator
     */
    private function getRequirements(
        string $searchTerm = null, 
        string $sortColumn = null, 
        string $sortOrder = null, 
        int $newItemsPerPage = null,
    ): LengthAwarePaginator
    {
        $requirements = TmsGear::query()

            // If there is a search term defined...
            ->when($searchTerm, function($query, $searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('remarks', 'like', '%' . $searchTerm . '%');
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

            // dd($requirements);
        return $requirements;
    }
}