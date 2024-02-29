<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsVehicle;
use Illuminate\Http\Request;
use App\Traits\DataBaseFilter;
use App\Http\Resources\GeneralResource;
use App\Http\Requests\TmsVehicleRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;


class TmsVehicleController extends Controller {

    use DataBaseFilter;
    private string $index = 'Vehicles/Index';
    private string $show = 'Vehicles/Show';
    private string $create = 'Vehicles/Create';
    private string $edit = 'Vehicles/Edit';

    /**
     * Returns records.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
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
    /**
     * Returns a single record
     * 
     * @param string $id
     * @return Response
     */
    public function show(string $id): Response
    {
        $record = TmsVehicle::find($id);

        return Inertia::render(
            $this->show, 
            [
                'record' => $record,
            ]
        );
    }

    /**
     * Returns the create view
     * 
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render($this->create);
    }

    /**
     * Creates a new vehicle
     * 
     * @param TmsVehicleRequest $request
     */
    public function store(TmsVehicleRequest $request)
    {
        $newRecord = $request->validated();

        $newlyCreatedRecord = TmsVehicle::create($newRecord);

        /**
         * Since a new vehicle is created, we send a success message to the FE. First step of this
         * is to put the message into the session. After redirecting to the edit page, we will send
         * this message to the FE, and then we will delete it from the session. So, the edit page
         * will know that a new record was created, and it will display the success message.
         */
        Session::put('vehicleCreate', 'Address created successfully!');

        /**
         * @Christoph said that we need to redirect the user after a successful create to the edit 
         * page.
         */
        return Inertia::location("{$newlyCreatedRecord->id}/edit");

    }

    /**
     * Edit a record.
     *
     * @param string $id
     * @return Response
     */
    public function edit(string $id): Response
    {
        $record = TmsVehicle::find($id);

        /**
         * Here we check if there is a session variable called 'vehicleCreate'. If yes, we send it
         * to the FE. And then we delete it from the session, with Session::forget('vehicleCreate').
         */
        $successMessage = Session::get('vehicleCreate');
        Session::forget('vehicleCreate');

        return Inertia::render(
            $this->edit, 
            [
                'record' => $record,

                /**
                 * This is only needed, when a new vehicle was created, and then the user is redirected
                 * to the edit page. In this case we send the success message to the FE.
                 */
                'successMessage' => $successMessage,
            ]
        );
    }

    /**
     * Updates a vehicle.
     * 
     * @param TmsVehicleRequest $request
     * @param string $id
     */
    public function update(TmsVehicleRequest $request, string $id): void
    {
        $newRecord = $request->validated();

        TmsVehicle::find($id)->update($newRecord);
    }

    /**
     * Deletes a vehicle
     * 
     * @param string $id
     * @return void
     */
    public function destroy(string $id): void
    {
        TmsVehicle::destroy($id);
    }
}