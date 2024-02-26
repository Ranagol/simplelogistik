<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsAddress;
use App\Models\TmsCountry;
use App\Models\TmsPartner;
use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use Illuminate\Http\Request;
use App\Services\AddressService;
use Faker\Provider\ar_EG\Address;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\TmsAddressRequest;
use App\Http\Resources\GeneralResource;
use App\Traits\DataBaseFilter;
use Illuminate\Http\Resources\Json\JsonResource;

class TmsAddressController extends Controller
{
    use DataBaseFilter;

    private string $index = 'Addresses/Index';
    private string $show = 'Addresses/Show';
    private string $create = 'Addresses/Create';
    private string $edit = 'Addresses/Edit';

    /**
     * Returns records.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $searchTerm = $request->searchTerm ?? "";
        $sortColumn = $request->sortColumn ?? "id";
        $sortOrder = $request->sortOrder ?? "ASC";
        $searchColumns = $request->searchColumns ?? ["first_name"];
        //pagination stuff sent from front-end
        $page = $request->page;
        $newItemsPerPage = $request->per_page ?? 10;

        //Temporary hardcoded stuff for development
        // $searchTerm = 'daniel';
        // $searchColumns = [
        //     'first_name',//simple search in the main model
        //     'last_name',//simple search in the main model
        //     'customer__first_name',//relationship search in the related model
        //     'forwarder__company_name',//relationship search in the related model
        // ];
        
        $records = $this->getRecords(
            new TmsAddress(),
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

    public function show(string $id): Response
    {
        $record = TmsAddress::find($id);

        return Inertia::render(
            $this->show, 
            [
                'record' => $record,
            ]
        );
    }

    public function create(): Response
    {
        return Inertia::render(
            $this->create
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
     */
    public function store(TmsAddressRequest $request)
    {
        /**
         * The validated method is used to get the validated data from the request.
         */
        $newRecord = $request->validated();//do validation

        $newlyCreatedRecord = TmsAddress::create($newRecord);

        /**
         * Since a new address is created, we send a success message to the FE. First step of this
         * is to put the message into the session. After redirecting to the edit page, we will send
         * this message to the FE, and then we will delete it from the session. So, the edit page
         * will know that a new record was created, and it will display the success message.
         */
        Session::put('addressCreate', 'Address created successfully!');

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
        $record = TmsAddress::find($id);

        /**
         * Here we check if there is a session variable called 'addressCreate'. If yes, we send it
         * to the FE. And then we delete it from the session, with Session::forget('addressCreate').
         */
        $successMessage = Session::get('addressCreate');
        Session::forget('addressCreate');

        return Inertia::render(
            $this->edit, 
            [
                'record' => $record,

                /**
                 * This is only needed, when a new address was created, and then the user is redirected
                 * to the edit page. In this case we send the success message to the FE.
                 */
                'successMessage' => $successMessage,
            ]
        );
    }

    public function update(TmsAddressRequest $request, string $id): void
    {
        /**
         * The validated method is used to get the validated data from the request.
         */
        $newRecord = $request->validated();//do validation

        TmsAddress::find($id)->update($newRecord);
    }

    /**
     * If this is a company return the company name, otherwise return the name of the person.
     * This name will be created from the first and last name.
     *
     * @return string
     */
    private function generateCustomerName(TmsCustomer $customer): string
    {
        if ($customer->company_name) {
            return $customer->company_name;
        }

        return $customer->first_name . ' ' . $customer->last_name;
    }
}


  