<?php

namespace App\Http\Controllers;

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

class TmsForwarderController extends Controller
{
    //These are paths to the Vue components
    private string $listPath = 'Forwarders/List/List';
    private string $createEditPath = 'Forwarders/CreateEdit/CreateEditBase';
    private string $detailsPath = 'Forwarders/Details/Details';

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

    public function index(Request $request): Response
    {
        $searchTerm = $request->searchTerm;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        //pagination stuff sent from front-end
        $page = $request->page;
        $newItemsPerPage = (int)$request->newItemsPerPage;
        
        $records = $this->forwarderService->getRecords(//Undefined variable $forwarderService
            $searchTerm, 
            $sortColumn, 
            $sortOrder, 
            $newItemsPerPage
        );

        return Inertia::render(
            $this->listPath, 
            [
                'records' => $records,
                'searchTerm' => $searchTerm,
                'sortColumn' => $sortColumn,
                'sortOrder' => $sortOrder,
            ]
        );
    }

    public function show(string $id): Response
    {
        $record = TmsForwarder::with(
            [
                //put here the relationships that you will need
            ]
        )->findOrFail($id);

        return Inertia::render(
            $this->detailsPath, 
            [
                'record' => $record,
            ]
        );
    }

    public function create(): Response
    {
        return Inertia::render(
            $this->createEditPath, 
            [
                'record' => new TmsForwarder(),//just an empty record
                'mode' => 'create',
            ]
        );
    }

    /**
     * Stores records. Inertia automatically sends succes or error feedback to the frontend.
     * A little explanation: here we only save the record into db.
     * This simply triggers onSuccess event in FE component, which then displays the success message
     */
    public function store(TmsForwarderRequest $request)
    {
        $newRecord = $request->validated();//do validation
        $newlyCreatedRecord = TmsForwarder::create($newRecord);

        /**
         * @Christoph said that we need to redirect the user after a successful create to the edit 
         * page. This is what we do here, otherwise this line would not be needed.
         */
        return Inertia::location("{$newlyCreatedRecord->id}/edit");
    }

    public function edit(string $id): Response
    {
        //Gets the relevant data for us from db.
        $record = TmsForwarder::with(
            [
                //put here the relationships that you will need
            ]
        )->findOrFail($id);

        return Inertia::render(
            $this->createEditPath, 
            [
                'record' => $record,
                'mode' => 'edit',
                //This is data for the select/options fields in the form, so the user can choose.
                'selectOptions' => [
                    'countries' => 'just testing',
                ]
            ]
        );
    }

    public function update(TmsForwarderRequest $request, string $id)
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


