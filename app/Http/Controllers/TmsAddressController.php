<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsAddress;
use App\Models\TmsCustomer;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\TmsAddressRequest;
use App\Models\TmsForwarder;
use Illuminate\Pagination\LengthAwarePaginator;

class TmsAddressController extends BaseController
{
    public function __construct()
    {
        $this->model = new TmsAddress();
        $this->vueIndexPath = 'Addresses/IndexAddress/Index';
        $this->vueCreateEditPath = 'Addresses/CreateEditAddress/CreateEditBase';
    }

    /**
     * This is used for dynamic validation. Which happens in the parent BaseController.
     *
     * @return string
     */
    protected function getRequestClass(): string
    {
        return TmsAddressRequest::class;
    }

    public function create(): Response
    {
        return Inertia::render(
            $this->vueCreateEditPath, 
            [
                // 'record' => $record,
                'mode' => 'create',
                'addressTypes' => TmsAddress::ADDRESS_TYPES,
                // we send all customers and forwarders to the FE, so that the user can select them
                'customers' => TmsCustomer::all()->map(function ($customer) {
                    return [
                        'id' => $customer->id,
                        'name' => $this->generateCustomerName($customer),
                    ];
                }),
                'forwarders' => TmsForwarder::all()->map(function ($forwarder) {
                    return [
                        'id' => $forwarder->id,
                        'name' => $forwarder->company_name,
                    ];
                }),

            ]
        );
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
     * Undocumented function
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
                'addressTypes' => TmsAddress::ADDRESS_TYPES,
                
                /**
                 * We send all customers and forwarders to the FE, so that the user can select them
                 * in an el-select. Because every address must belong to a customer and a forwarder.
                 */
                'customers' => TmsCustomer::all()->map(function ($customer) {
                    return [
                        'id' => $customer->id,
                        'name' => $this->generateCustomerName($customer),
                    ];
                }),
                'forwarders' => TmsForwarder::all()->map(function ($forwarder) {
                    return [
                        'id' => $forwarder->id,
                        'name' => $forwarder->company_name,
                    ];
                }),
                /**
                 * We send all existing country codes in the address table to the FE, so they would
                 * become select options. So the user can selecte a country for the address. IMPORTANT:
                 * although country codes are numbers (Example: 4 for Afghanistan), we send them as
                 * country names (Example: Afghanistan). This is because we use mutators and 
                 * accessors for this. Find the mutator in the TmsAddress model.
                 */
                'countryCodes' => TmsAddress::select('country_code')
                        ->distinct()
                        ->get()
                        ->map(function ($countryCode) {
                            return $countryCode->country_code;
                        }),
            ]
        );
    }
}