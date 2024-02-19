<?php

namespace App\Http\Controllers;

use App\Http\Resources\GeneralResource;
use App\Traits\DataBaseFilter;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsVehicle;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TmsVehicleController extends Controller {

    use DataBaseFilter;
    private string $index = 'Vehicles/Index';
    private string $show = 'Vehicles/Show';
    private string $create = 'Vehicles/Create';
    private string $edit = 'Vehicles/Edit';


    public function index(Request $request) {
        $searchTerm = $request->searchTerm;
        $sortColumn = $request->sortColumn ?? "id";
        $sortOrder = $request->sortOrder ?? "ASC";
        $searchColumns = $request->searchColumns ?? [];
        //pagination stuff sent from front-end
        $page = $request->page;
        $newItemsPerPage = $request->per_page ?? 10;

        $records = $this->getRecords(
            new TmsVehicle(),
            $searchTerm, 
            $sortColumn, 
            $sortOrder, 
            $newItemsPerPage,
            $searchColumns,
            [
                'forwarder',
                'addresses'
            ]
        );

        $records = GeneralResource::collection($records);

        return Inertia::render(
            $this->index, 
            [
                'records' => $records,
                'search' => $searchTerm,
                'search_in' => $searchColumns,
                'per_page' => $newItemsPerPage,
                'order_by' => $sortColumn, // table column to order by (id, name, date, etc...)
                'order' => $sortOrder // Ascending - Descending
            ]
        );
    }
    public function show(){
        return Inertia::render($this->show, [

        ]);
    }
    public function create(){
        return Inertia::render($this->create, [

        ]);
    }
    public function edit(){
        return Inertia::render($this->edit, [

        ]);
    }
    /**
     * Creates a new vehicle
     */
    public function store(Request $request){
        return Inertia::render("", [

        ]);
    }
    /**
     * Updates a new vehicle
     */
    public function update(){
        return Inertia::render($this->edit, [

        ]);
    }
    /**
     * Deletes a vehicle
     */
    public function destroy($id){
        
    }

}