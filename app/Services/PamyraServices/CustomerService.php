<?php

namespace App\Services\PamyraServices;

use App\Models\TmsCustomer;

class CustomerService {

    public function handle(array $customerPamyra): int
    {
        $duplicateCustomer = $this->checkForDuplicate($customerPamyra);

        if( $duplicateCustomer === null) {

            //If there is no duplicate in db, create a new customer and return his id
            $customerId = $this->createCustomer($customerPamyra);
            return $customerId;

        } 

        //If there is a duplicate in db already... return the duplicate customer id
        return $duplicateCustomer->id;
    }

    private function checkForDuplicate($customerPamyra)
    {
        //So far we hardcode that this is not a duplicate. So we simply return null.
        return null;
    }

    private function createCustomer($customerPamyra)
    {
       $customerDb = new TmsCustomer();
       $customerDb->company_name = $customerPamyra['company'];
       $customerDb->email = $customerPamyra['mail'];
       $customerDb->first_name = $customerPamyra['firstName'];
       $customerDb->last_name = $customerPamyra['name'];
       $customerDb->tax_number = $customerPamyra['vatId'];
       $customerDb->phone = $customerPamyra['phone'];
    }
}