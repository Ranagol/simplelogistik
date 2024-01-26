<?php

namespace App\Services\PamyraServices;

use App\Models\TmsCustomer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerService {

    public function handle(array $customerPamyra): int
    {
        $duplicateCustomer = $this->checkForDuplicate($customerPamyra);

        //If there is a duplicate in db
        if( $duplicateCustomer !== null) {
            return $duplicateCustomer->id;
        } 

        //If there is no duplicate in db
        $this->validate($customerPamyra);
        $customerId = $this->insertCustomer($customerPamyra);
        return $customerId;
    }

    private function checkForDuplicate($customerPamyra)
    {
        //So far we hardcode that this is not a duplicate. So we simply return null.
        // return null;

        $first_name = $customerPamyra['firstName'];
        $last_name = $customerPamyra['name'];
        $phone = $customerPamyra['phone'];

        $customer = DB::table('tms_customers')->where(
            [
                ['first_name', '=', $first_name],
                ['last_name', '=', $last_name],
                ['phone', '=', $phone],
            ]
        )->first();

        return $customer;
    }

    private function validate(array $customerPamyra): void
    {
        // Define the validation rules
        $rules = [
            'company' => 'nullable|string',
            'mail' => 'nullable|email',
            'firstName' => 'required|string',
            'name' => 'required|string',
            'vatId' => 'nullable|string',
            'phone' => 'required|string',
            // 'internal_id' => 'required|string
        ];

        // Validate the data
        $validator = Validator::make($customerPamyra, $rules);

        // If the validation fails, throw an exception
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }

    private function insertCustomer($customerPamyra)
    {
        $customerId = DB::table('tms_customers')->insertGetId([
            'company_name' => $customerPamyra['company'],
            'email' => $customerPamyra['mail'],
            'first_name' => $customerPamyra['firstName'],
            'last_name' => $customerPamyra['name'],
            'tax_number' => $customerPamyra['vatId'],
            'phone' => $customerPamyra['phone'],
            'internal_id' => 'temporary testing',//TODO ANDOR: correct this temporary solution
        ]);

        return $customerId;
    }
}