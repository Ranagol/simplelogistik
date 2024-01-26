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
    
    public function handle(
        array $customerPamyra,
        bool $isHeadquarter,
        bool $isBilling,
        int $customerId
    ): TmsAddress | null
    {
        $this->separateStreetAndHouseNumber($customerPamyra);
        $this->setCountryId($customerPamyra);
        $this->setPartnerId();
        $duplicateAddress = $this->checkForDuplicate(
            $customerPamyra,
            $isHeadquarter,
            $isBilling,
            $customerId
        );

        //If there is a duplicate in db
        if( $duplicateAddress !== null) {
            return $duplicateAddress;
        } 

        //If there is no duplicate in db
        $this->validate($customerPamyra['address']);
        $address = $this->createAddress($customerPamyra);
        return $address;
    }

    /**
     * Sets the partner id from the partner name. Since we are handling here Pamyra orders, the 
     * partner name is always Pamyra. And Pamyra id should be always 1.
     *
     * @return void
     */
    private function setPartnerId(): void
    {
        $this->partnerId = DB::table('tms_partners')
                            ->where('company_name', 'Pamyra')
                            ->where('id', 1)
                            ->first()
                            ->id;
    }
    
    /**
     * Sets the country id from the country code.
     *
     * @param array $customerPamyra
     * @return void
     */
    private function setCountryId(array $customerPamyra): void
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
        if (!preg_match('/^([^\d]*[^\d\s]) *(\d.*)$/', $streetAndNumber, $match)) {//Extract street and number
            throw new \Exception('Invalid address format');//If something is wrong with the extraction, throw an exception.
        }
        $this->street = $match[1];//Example:"Am Hochhaus".
        $this->houseNumber = $match[2];//Example:"70".
    }

    /**
     * Checks if there is a duplicate address in the database.
     * 
     * We must check here for 3 cases:
     * 1. isHeadquarter = true
     * 2. isBilling = true
     * 3. isHeadquarter = true && isBilling = true (when an address is headquarter and billing at the same time) 
     * Undocumented function
     *
     * @param array $customerPamyra
     * @param boolean $isHeadquarter
     * @param boolean $isBilling
     * @param integer $customerId
     * @return void
     */
    private function checkForDuplicate(
        array $customerPamyra,
        bool $isHeadquarter,
        bool $isBilling,
        int $customerId
    ): TmsAddress | null
    {
        $duplicateAddress = TmsAddress::where('street', $this->street)
                                ->where('house_number', $this->houseNumber)
                                ->where('country_id', $this->countryId)
                                ->where('partner_id', $this->partnerId)
                                ->where('customer_id', $customerId)
                                ->when($isHeadquarter && $isBilling, function ($query) {
                                    return $query->where('is_headquarter', true)
                                                ->where('is_billing', true);
                                })
                                ->when($isHeadquarter, function ($query) {
                                    return $query->where('is_headquarter', true);
                                })
                                ->when($isBilling, function ($query) {
                                    return $query->where('is_billing', true);
                                })
                                ->first();

        return $duplicateAddress;
    }

    private function validate(array $addressPamyra): void
    {
        // Define the validation rules
        $rules = [
            'city' => ['required', 'string'],
            'countryCode' => ['required', 'string'],
            'postalCode' => ['required', 'string'],
            'street' => ['required', 'string'],
            'addressAdditionalInformation' => ['nullable', 'string'],
        ];

        // Validate the data
        $validator = Validator::make($addressPamyra, $rules);

        // Throw an exception if validation fails
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }

    private function createAddress(array $customerPamyra): TmsAddress
    {
        $address = new TmsAddress();
        $address->street = $this->street;
        $address->house_number = $this->houseNumber;
        $address->country_id = $this->countryId;
        $address->partner_id = $this->partnerId;
        $address->customer_id = $this->customerId;
        $address->is_headquarter = $isHeadquarter;
        $address->is_billing = $isBilling;
        $address->save();
        return $address;
    }
}