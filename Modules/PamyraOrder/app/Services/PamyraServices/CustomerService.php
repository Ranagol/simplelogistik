<?php

namespace Modules\PamyraOrder\app\Services\PamyraServices;

use App\Models\TmsCustomer;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\TmsCustomerRequest;
use Illuminate\Support\Facades\Validator;

class CustomerService {

    /**
     * Validation rules from TmsCustomerRequest.
     *
     * @var array
     */
    private array $validationRules;

    public function __construct()
    {
        /**
         * We copy here the validation rules from the TmsCustomerRequest. Because we want to use them
         * in this class. And we can't use them directly from the TmsCustomerRequest, because it is
         * a FormRequest. And we can't use a FormRequest in a class. So, we copy the rules here.
         */
        $tmsCustomerRequest = new TmsCustomerRequest();
        $this->validationRules = $tmsCustomerRequest->customerRules();
    }

    /**
     * Handle the customer data from Pamyra. This is the main function that triggers all the other functions.
     *
     * @param array $customerPamyra
     * @return int
     * @throws \Exception
     */
    public function handle(array $customerPamyra): int
    {
        $duplicateCustomer = $this->checkForDuplicate($customerPamyra);

        //If there is a duplicate in db
        if( $duplicateCustomer !== null) {
            return $duplicateCustomer->id;
        } 

        //If there is no duplicate in db
        $customer = $this->createCustomer($customerPamyra);
        return $customer->id;
    }

    /**
     * Check if the customer already exists in the database.
     *
     * @param array $customerPamyra
     * @return TmsCustomer|null
     */
    private function checkForDuplicate($customerPamyra): TmsCustomer|null
    {
        $first_name = $customerPamyra['FirstName'];
        $last_name = $customerPamyra['Name'];
        $phone = $customerPamyra['Phone'];

        $customer = TmsCustomer::where('first_name', $first_name)
                                ->where('last_name', $last_name)
                                ->where('phone', $phone)
                                ->first();

        return $customer;
    }

    /**
     * Create a new customer in the database.
     *
     * @param array $customerPamyra
     * @return TmsCustomer
     * @throws \Exception
     */
    private function createCustomer(array $customerPamyra): TmsCustomer
    {
        $customerArray = [
            'company_name' => $customerPamyra['Company'] ?? null,
            'email' => $customerPamyra['Mail'] ?? 'missing',
            'first_name' => $customerPamyra['FirstName'] ?? 'missing',
            'last_name' => $customerPamyra['Name'] ?? 'missing',
            'tax_number' => $customerPamyra['VatId'] ?? null,
            'phone' => $customerPamyra['Phone'] ?? 'missing',
            'internal_id' => 'temporary testing' ?? null,
            'customer_type' => $this->createCustomerType($customerPamyra),
            'invoice_dispatch' => array_search('Direct', TmsCustomer::INVOICE_DISPATCHES),//This will be 1.
            'invoice_shipping_method' => 'Email',
        ];

        $this->validate($customerArray);
        
        $customer = TmsCustomer::create($customerArray);

        return $customer;//this will have the id
    }

    /**
     * if customer has company then customer_type is 'Bussiness customer, else 'Private customer'.
     * But instead of these strings, we use the keys of the CUSTOMER_TYPES array. 1 for 'Bussiness 
     * customer' and 2 for 'Private customer'.
     *
     * @param array $customerPamyra
     * @return string
     */
    private function createCustomerType(array $customerPamyra): string
    {
        //Check if the customer has a company
        $company = $customerPamyra['Company'] ?? null;
        $businessCustomerKey = array_search('Bussiness customer', TmsCustomer::CUSTOMER_TYPES);//This will be 1.
        $privateCustomerKey = array_search('Private customer', TmsCustomer::CUSTOMER_TYPES);//This will be 2.

        return $company ? $businessCustomerKey : $privateCustomerKey;
    }

    /**
     * Validate the customer data.
     * 
     * @Christoph said, that temporarily we just need to throw a simple basic exception if the 
     * validation fails. Later we will handle this with monitoring.
     *
     * @param array $customer
     * @return void
     */
    private function validate(array $customerArray): void
    {
        // Validate the data
        $validator = Validator::make($customerArray, $this->validationRules);

        if ($validator->fails()) {
            echo $validator->errors()->first();
            Log::error($validator->errors()->first());
        }
    }
}