<?php

namespace App\Http\Controllers;

use App\Http\Resources\GeneralResource;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsOrder;
use App\Models\TmsParcel;
use App\Models\TmsCountry;
use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use Illuminate\Http\Request;
use App\Services\ForwarderService;
use App\Http\Requests\TmsForwarderRequest;
use App\Traits\DataBaseFilter;
use Illuminate\Http\RedirectResponse;

class TmsForwarderController extends Controller
{
    use DataBaseFilter;

    private string $index = 'Forwarders/Index';
    private string $show = 'Forwarders/Show';
    private string $create = 'Forwarders/Create';
    private string $edit = 'Forwarders/Edit';

    /**
     * Contains helper methods for the TmsForwarderController.
     *
     * @var ForwarderService
     */
    private ForwarderService $forwarderService;

    public function __construct(ForwarderService $forwarderService)
    {
        $this->forwarderService = $forwarderService;
    }

    /**
     * Returns the records for the list page.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $searchTerm = $request->searchTerm ?? "";
        $sortColumn = $request->sortColumn ?? "id";
        $sortOrder = $request->sortOrder ?? "ASC";
        $searchColumns = $request->searchColumns ?? [];
        //pagination stuff sent from front-end
        $page = $request->page;
        $newItemsPerPage = $request->per_page ?? 10;
        
        $records = $this->getRecords(
            new TmsForwarder(),
            $searchTerm, 
            $sortColumn, 
            $sortOrder, 
            $newItemsPerPage,
            $searchColumns
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
     * Returns the record for the details page.
     *
     * @param string $id
     * @return Response
     */
    public function show(string $id): Response
    {
        $record = TmsForwarder::with(
            [
                //put here the relationships that you will need
            ]
        )->findOrFail($id);

        return Inertia::render(
            $this->show, 
            [
                'record' => $record,
            ]
        );
    }

    /**
     * Returns the record for the create page.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render(
            $this->create, 
            [
                'record' => new TmsForwarder(),//just an empty record
            ]
        );
    }

    /**
     * Stores records. Inertia automatically sends succes or error feedback to the frontend.
     * A little explanation: here we only save the record into db.
     * This simply triggers onSuccess event in FE component, which then displays the success message
     *
     * @param TmsForwarderRequest $request
     * @return RedirectResponse
     */
    public function store(TmsForwarderRequest $request): RedirectResponse
    {
        $newRecord = $request->validated();//do validation
        $newlyCreatedRecord = TmsForwarder::create($newRecord);

        /**
         * @Christoph said that we need to redirect the user after a successful create to the edit 
         * page. This is what we do here, otherwise this line would not be needed.
         */
        return Inertia::location("{$newlyCreatedRecord->id}/edit");
    }

    /**
     * Returns the record for the edit page.
     *
     * @param string $id
     * @return Response
     */
    public function edit(string $id): Response
    {
        //Gets the relevant data for us from db.
        $record = TmsForwarder::with(
            [
                //put here the relationships that you will need
            ]
        )->findOrFail($id);

        return Inertia::render(
            $this->edit, 
            [
                'record' => $record,
            ]
        );
    }

    /**
     * Updates forwarder.
     *
     * @param TmsForwarderRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(TmsForwarderRequest $request, string $id): RedirectResponse
    {
        $newRecord = $request->validated();//do validation
        $record = TmsForwarder::findOrFail($id);//find the relevant record
        $record->update($newRecord);//update it

        return Inertia::location("/forwarders/{$record->id}/edit");
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
        TmsForwarder::destroy($id);
    }
}


