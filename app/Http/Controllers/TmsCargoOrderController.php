<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Models\TmsCargoOrder;
use App\Http\Controllers\BaseController;
use App\Http\Requests\TmsCargoOrderRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class TmsCargoOrderController extends BaseController
{
    public function __construct()
    {
        $this->model = new TmsCargoOrder();
        $this->vueIndexPath = 'CargoOrders/IndexCargoOrder/Index';
        $this->vueCreateEditPath = 'CargoOrders/CreateEditCargoOrder/CreateEditBase';
    }

    /**
     * This is used for dynamic validation. Which happens in the parent BaseController.
     *
     * @return string
     */
    protected function getRequestClass(): string
    {
        return TmsCargoOrderRequest::class;
    }

    public function create(): Response
    {
        return Inertia::render(
            $this->vueCreateEditPath, 
            [
                // 'record' => $record,
                'mode' => 'create',
            ]
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
    public function store()
    {
        /**
         * This is a bit tricky. How to use here dynamic validation, depending which controller is 
         * calling this method?
         * In this code, app($this->getRequestClass()) will return an instance of TmsCustomerRequest 
         * when called from TmsCustomerController.
         * So basically, here we trigger TmsCustomerRequest. The $request is an instance of
         * TmsCustomerRequest.
         */
        $request = app($this->getRequestClass());//
        
        /**
         * The validated method is used to get the validated data from the request.
         */
        $newRecord = $request->validated();//do validation

        /**
         * 1. Find the relevant record and...
         * 2. ...update it.
         * 3. Get the newly created record, and return it to the FE.
         */
        $newlyCreatedRecord = $this->model->create($newRecord);

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
        $record = $this->model::find($id);

        return Inertia::render(
            $this->vueCreateEditPath, 
            [
                'record' => $record,
                'mode' => 'edit',
            ]
        );
    }
}
