<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsVehicle;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\TmsVehicleRequest;

class TmsVehicleController extends Controller
{
     /**
     * Returns vehicles.
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
        
        $vehicles = $this->getVehicles($searchTerm, $sortColumn, $sortOrder, $newItemsPerPage);

        return Inertia::render('Vehicles/Index', [
            'dataFromController' => $vehicles,
            'searchTermProp' => $searchTerm,
            'sortColumnProp' => $sortColumn,
            'sortOrderProp' => $sortOrder,
        ]);
    }

    public function show(string $id): void
    {
        $vehicle = TmsVehicle::find($id);
    }

    /**
     * Stores vehicles. Inertia automatically sends succes or error feedback to the frontend.
     * 
     * A little explanation: here we only save the vehicle into db.
     * This simply triggers onSuccess event in FE component, which then displays the success message
     * to the user, and then the FE component calls the $this->index() method, which returns the vehicles.
     * So, the user gets his feedback, and the vehicle list is refreshed.
     *
     * @param TmsVehicleRequest $request
     * @return void
     */
    public function store(TmsVehicleRequest $request): void
    {
        TmsVehicle::create($request->all());
    }

    /**
     * Updates vehicles. Inertia automatically sends succes or error feedback to the frontend.
     *
     * @param TmsVehicleRequest $request
     * @param [type] $id
     * @return void
     */
    public function update(TmsVehicleRequest $request, string $id): void
    {
        TmsVehicle::find($id)->update($request->all());
    }

    /**
     * Deletes vehicles. This triggers the onSuccess event in FE component, which then displays
     * the success message to the user, and then the FE component calls the $this->index() method,
     * which returns the vehicles. So, the user gets his feedback, and the vehicle list is refreshed.
     * 
     * @param [type] $id
     * @return void
     */
    public function destroy(Request $request, string $id): void
    {
        TmsVehicle::destroy($id);
    }

    /**
     * Deletes multiple vehicles at the same time.
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
        TmsVehicle::destroy($ids);
    }

    /**
     * Returns vehicles.
     *
     * @param string|null $searchTerm
     * @param string|null $sortColumn
     * @param string|null $sortOrder
     * @param integer|null $newItemsPerPage
     * @return LengthAwarePaginator
     */
    private function getVehicles(
        string $searchTerm = null, 
        string $sortColumn = null, 
        string $sortOrder = null, 
        int $newItemsPerPage = null,
    ): LengthAwarePaginator
    {
        $vehicles = TmsVehicle::query()

            // If there is a search term defined...
            ->when($searchTerm, function($query, $searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('vehicle_type', 'like', '%' . $searchTerm . '%')
                    ->orWhere('plate_number', 'like', '%' . $searchTerm . '%');
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

            // dd($vehicles);
        return $vehicles;
    }
}