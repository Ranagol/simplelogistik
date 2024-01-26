<?php

namespace App\Services\PamyraServices;

use App\Models\TmsAddress;
use App\Models\TmsCustomer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AddressService {

    private string $houseNumber;
    private string $street;
    private int $countryId;
    private int $partnerId;
    
    public function handle(array $customerPamyra, string $addressType, int $customerId): int
    {
        $this->separateStreetAndHouseNumber($customerPamyra);
        $this->setCountryId($customerPamyra);
        $this->setPartnerId($customerPamyra);

        $duplicateAddress = $this->checkForDuplicate($customerPamyra);

        //If there is a duplicate in db
        if( $duplicateAddress !== null) {
            return $duplicateAddress->id;
        } 

        //If there is no duplicate in db
        $this->validate($customerPamyra);
        $addressId = $this->insertAddress($customerPamyra);
        return $addressId;
    }

    private function setPartnerId($customerPamyra): void
    {
        $this->partnerId = DB::table('tms_partners')
                            ->where('company_name', 'Pamyra')
                            ->where('id', 1)
                            ->first()
                            ->id;
    }

    private function setCountryId($customerPamyra): void
    {
        $countryCode = $customerPamyra['address']['countryCode'];
        $this->countryId = DB::table('tms_countries')->where('alpha2_code', $countryCode)->first()->id;
    }

    /**
     * the addresses from orders from Pamyra have the street name and the house number together.  
     * Example:"street": "Am Hochhaus 70".
     * This must be separated into street and house number.
     * Source: https://stackoverflow.com/questions/7488557/separate-street-name-from-street-number
     * 
     * @param array $customerPamyra
     * @return void
     */
    private function separateStreetAndHouseNumber(array $customerPamyra): void
    {
        $streetAndNumber = $customerPamyra['address']['street'];//Example:"street": "Am Hochhaus 70".
        preg_match('/^([^\d]*[^\d\s]) *(\d.*)$/', $streetAndNumber, $match);
        $this->street = $match[1];//Example:"Am Hochhaus".
        $this->houseNumber = $match[2];//Example:"70".
    }

    private function checkForDuplicate($customerPamyra)
    {
        return null;
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

        // Throw an exception if validation fails
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }

    private function insertAddress(array $customerPamyra): int
    {

    }
}