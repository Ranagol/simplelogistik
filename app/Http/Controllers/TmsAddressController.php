<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsAddress;
use App\Models\TmsCustomer;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\TmsAddressRequest;

class TmsAddressController extends Controller
{
     /**
     * Returns addresses.
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

        
        $addresses = $this->getAddresses($searchTerm, $sortColumn, $sortOrder, $newItemsPerPage);

        $t = 8;
        return Inertia::render('Addresses/Index', [
            'dataFromController' => $addresses,
            'searchTermProp' => $searchTerm,
            'sortColumnProp' => $sortColumn,
            'sortOrderProp' => $sortOrder,
            // 'elDialogVisibleProp' => $elDialogVisible,
        ]);
    }

    public function show(string $id): void
    {
        $customer = TmsAddress::find($id);
    }

    /**
     * Stores addresses. Inertia automatically sends succes or error feedback to the frontend.
     * 
     * A little explanation: here we only save the customer into db.
     * This simply triggers onSuccess event in FE component, which then displays the success message
     * to the user, and then the FE component calls the $this->index() method, which returns the addresses.
     * So, the user gets his feedback, and the customer list is refreshed.
     *
     * @param TmsAddressRequest $request
     * @return void
     */
    public function store(TmsAddressRequest $request): void
    {
        TmsAddress::create($request->all());
    }

    /**
     * Updates addresses. Inertia automatically sends succes or error feedback to the frontend.
     *
     * @param TmsAddressRequest $request
     * @param [type] $id
     * @return void
     */
    public function update(TmsAddressRequest $request, string $id): void
    {
        TmsAddress::find($id)->update($request->all());
    }

    /**
     * Deletes addresses. This triggers the onSuccess event in FE component, which then displays
     * the success message to the user, and then the FE component calls the $this->index() method,
     * which returns the addresses. So, the user gets his feedback, and the customer list is refreshed.
     * 
     * @param [type] $id
     * @return void
     */
    public function destroy(Request $request, string $id): void
    {
        TmsAddress::destroy($id);
    }

    /**
     * Deletes multiple addresses at the same time.
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
        TmsAddress::destroy($ids);
    }

    /**
     * Returns addresses.
     *
     * @param string|null $searchTerm
     * @param string|null $sortColumn
     * @param string|null $sortOrder
     * @param integer|null $newItemsPerPage
     * @return LengthAwarePaginator
     */
    private function getAddresses(
        string $searchTerm = null, 
        string $sortColumn = null, 
        string $sortOrder = null, 
        int $newItemsPerPage = null,
    ): LengthAwarePaginator
    {
        $addresses = TmsAddress::query()

            // If there is a search term defined...
            ->when($searchTerm, function($query, $searchTerm) {
                $query->where('first_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('street', 'like', '%' . $searchTerm . '%')
                    ->orWhere('city', 'like', '%' . $searchTerm . '%');
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

            // dd($addresses);
        return $addresses;
    }
}