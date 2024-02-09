<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsVehicle;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TmsVehicleController extends Controller {

    private string $index = 'Vehicles/Index';
    private string $show = 'Vehicles/Show';
    private string $create = 'Vehicles/Create';
    private string $edit = 'Vehicles/Edit';


    public function index(){
        return Inertia::render($this->index, [
            "data" => TmsVehicle::paginate(10),
        ]);
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