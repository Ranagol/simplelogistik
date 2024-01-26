<?php

namespace App\Services\PamyraServices;

use App\Models\TmsAddress;
use App\Models\TmsCustomer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AddressService {
    
        public function handle(array $addressPamyra): int
        {
            $duplicateAddress = $this->checkForDuplicate($addressPamyra);
    
            //If there is a duplicate in db
            if( $duplicateAddress !== null) {
                return $duplicateAddress->id;
            } 
    
            //If there is no duplicate in db
            $this->validate($addressPamyra);
            $addressId = $this->insertAddress($addressPamyra);
            return $addressId;
        }
    
        private function checkForDuplicate($addressPamyra)
        {
            //So far we hardcode that this is not a duplicate. So we simply return null.
            // return null;
    
            $first_name = $addressPamyra['firstName'];
            $last_name = $addressPamyra['name'];
            $phone = $addressPamyra['phone'];
    
            $address = DB::table('tms_addresses')->where(
                [
                    ['first_name', '=', $first_name],
                    ['last_name', '=', $last_name],
                    ['phone', '=', $phone],
                ]
            )->first();
    
            return $address;
        }
    
        private function validate(array $addressPamyra): void
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
            $validator = Validator::make($addressPamyra, $rules);
    
            // Throw an exception if validation fails
            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }
        }
    
        private function insertAddress(array $addressPamyra): int
        {
    
        }
}