<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use Illuminate\Http\Request;
use App\Traits\DataBaseFilter;
use App\Http\Resources\GeneralResource;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\TmsCustomerRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class TmsCustomerController extends Controller
{
    use DataBaseFilter;

    private string $index = 'Customers/Index';
    private string $show = 'Customers/Show';
    private string $create = 'Customers/Create';
    private string $edit = 'Customers/Edit';

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
        $searchColumns = $request->searchColumns ?? ["company"];
        //pagination stuff sent from front-end
        $page = $request->page;
        $newItemsPerPage = $request->per_page ?? 10;
        
        $records = $this->getRecords(
            new TmsCustomer(),
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
        $record = TmsCustomer::with(
            [
                'addresses'
            ]
        )->find($id);

        return Inertia::render(
            $this->show, 
            [
                'record' => $record,
            ]
        );
    }

    public function create(): Response
    {
        return Inertia::render($this->create);
    }

    /**
     * Stores records. Inertia automatically sends succes or error feedback to the frontend.
     * 
     * A little explanation: here we only save the record into db.
     * This simply triggers onSuccess event in FE component, which then displays the success message
     * to the user, and then the FE component calls the $this->index() method, which returns the records.
     * So, the user gets his feedback, and the record list is refreshed.
     */
    // public function store(Request $request)
    public function store(TmsCustomerRequest $request)
    {
        /**
         * The validated method is used to get the validated data from the request.
         */
        $newRecord = $request->validated();

        $newlyCreatedRecord = TmsCustomer::create($newRecord);

        /**
         * Since a new address is created, we send a success message to the FE. First step of this
         * is to put the message into the session. After redirecting to the edit page, we will send
         * this message to the FE, and then we will delete it from the session. So, the edit page
         * will know that a new record was created, and it will display the success message.
         */
        Session::put('customerCreate', 'Customer created successfully!');

        /**
         * @Christoph said that we need to redirect the user after a successful create to the edit 
         * page.
         */
        return Inertia::location("{$newlyCreatedRecord->id}/edit");
    }

    /**
     * We have overwrittten this function from the parent, because we need here customers with
     * contact addresses.
     *
     * @param string $id
     * @return Response
     */
    public function edit(string $id): Response
    {
        $record = TmsCustomer::find($id);

        /**
         * Here we check if there is a session variable called 'customerCreate'. If yes, we send it
         * to the FE. And then we delete it from the session, with Session::forget.
         */
        $successMessage = Session::get('customerCreate');
        Session::forget('customerCreate');

        return Inertia::render(
            $this->edit, 
            [
                'record' => $record,

                /**
                 * This is only needed, when a new customer was created, and then the user is redirected
                 * to the edit page. In this case we send the success message to the FE.
                 */
                'successMessage' => $successMessage,
            ]
        );
    }

    /**
     * Updates records. Inertia automatically sends succes or error feedback to the frontend.
     *
     * @param string $id
     * @return void
     */
    public function update(TmsCustomerRequest $request, string $id): void
    {
        /**
         * The validated method is used to get the validated data from the request.
         */
        $newRecord = $request->validated();//do validation

        TmsCustomer::find($id)->update($newRecord);
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
        TmsCustomer::destroy($id);
    }


    /**
     * Comments about the customer writes into the db.
     *
     * @param Request $request
     * @param TmsCustomer $customer
     * @return void
     */
    public function addComment(Request $request, TmsCustomer $customer)
    {
        //comment validation
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        //Get the logged in user
        $user = auth()->user();

        //Get the current date in this format 2023-12-04 14:01:26
        $date = date('Y-m-d H:i:s');

        //Getting the currently existing comments (all of them)
        $comments = $customer->comments;

        //Formating the new comment that we want to add to the existing comments
        $comments[] = [
            'user_name' => $user->name,
            'comment' => $request->comment,
            'date' => $date,
        ];

        //Updating the comments column in the customers table
        $customer->update([
            'comments' => $comments,
        ]);
    }
}


