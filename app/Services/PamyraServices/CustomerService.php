<?php

namespace App\Services\PamyraServices;

use App\Http\Requests\TmsCustomerRequest;
use App\Models\TmsCustomer;
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
        $first_name = $customerPamyra['firstName'];
        $last_name = $customerPamyra['name'];
        $phone = $customerPamyra['phone'];

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
            'company_name' => $customerPamyra['company'],
            'email' => $customerPamyra['mail'],
            'first_name' => $customerPamyra['firstName'],
            'last_name' => $customerPamyra['name'],
            'tax_number' => $customerPamyra['vatId'],
            'phone' => $customerPamyra['phone'],
            'internal_id' => 'temporary testing',
        ];

        $this->validate($customerArray);//for validation we must transform model to array
        
        $customer = TmsCustomer::create($customerArray);

        return $customer;//this will have the id
    }

    /**
     * Validate the customer data.
     *
     * @param array $customer
     * @throws \Exception
     */
    private function validate(array $customerArray): void
    {
        // Validate the data
        $validator = Validator::make($customerArray, $this->validationRules);

        // If the validation fails, throw an exception
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }
}