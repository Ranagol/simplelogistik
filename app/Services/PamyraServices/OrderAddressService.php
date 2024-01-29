<?php

namespace App\Services\PamyraServices;

use App\Models\TmsOrderAddress;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TmsAddressRequest;
use Illuminate\Support\Facades\Validator;

class OrderAddressService {

    private string $houseNumber;
    private string $street;
    private int $countryId;

    /**
     * Validation rules from TmsAddressRequest.
     *
     * @var array
     */
    private array $validationRules;

    public function __construct()
    {
        /**
         * We copy here the validation rules from the TmsAddressRequest. Because we want to use them
         * in this class. And we can't use them directly from the TmsAddressRequest, because it is
         * a FormRequest. And we can't use a FormRequest in a class. So, we copy the rules here.
         * 
         * Note: we use TmsAddressRequest for validation. Both use the same rules.
         */
        $tmsAddressRequest = new TmsAddressRequest();
        $this->validationRules = $tmsAddressRequest->addressRules();
    }

    public function handle(
        array $customerPamyra,
        int $orderId,
        int $customerId,
        int $partnerId,
        int $addressType//The address_type for pickup is 3 and for delivery is 4.
    ): TmsOrderAddress | null
    {
        $this->separateStreetAndHouseNumber($customerPamyra);
        $this->setCountryId($customerPamyra);
        
        // $duplicateAddress = $this->checkForDuplicate(
        //     $isHeadquarter,
        //     $isBilling,
        //     $customerId,
        //     $partnerId
        // );

        //If there is a duplicate in db
        // if( $duplicateAddress !== null) {
        //     return $duplicateAddress;
        // } 

        $address = $this->createAddress(
            $customerPamyra, 
            $isHeadquarter, 
            $isBilling, 
            $customerId,
            $partnerId
        );

        return $address;
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
        bool $isHeadquarter,
        bool $isBilling,
        int $customerId,
        int $partnerId
    ): TmsOrderAddress | null
    {
        $duplicateAddress = TmsOrderAddress::where('street', $this->street)
                                ->where('house_number', $this->houseNumber)
                                ->where('country_id', $this->countryId)
                                ->where('partner_id', $partnerId)
                                ->where('customer_id', $customerId)
                                ->when($isHeadquarter, function ($query) {
                                    return $query->where('is_headquarter', true);
                                })
                                ->when($isBilling, function ($query) {
                                    return $query->where('is_billing', true);
                                })
                                ->first();

        return $duplicateAddress;
    }

    /**
     * Creates an address in the database.
     *
     * @param array $customerPamyra
     * @param boolean $isHeadquarter
     * @param boolean $isBilling
     * @param integer $customerId
     * @return TmsOrderAddress
     */
    private function createAddress(
        array $customerPamyra,
        bool $isHeadquarter,
        bool $isBilling,
        int $customerId,
        int $partnerId
    ): TmsOrderAddress
    {

        $addressArray = [
            'customer_id' => $customerId,
            'country_id' => $this->countryId,
            'partner_id' => $partnerId,
            'company_name' => $customerPamyra['company'],
            'first_name' => $customerPamyra['firstName'],
            'last_name' => $customerPamyra['name'],
            'street' => $this->street,
            'house_number' => $this->houseNumber,
            'zip_code' => $customerPamyra['address']['postalCode'],
            'city' => $customerPamyra['address']['city'],
            'address_additional_information' => $customerPamyra['address']['addressAdditionalInformation'],
            'phone' => $customerPamyra['phone'],
            'email' => $customerPamyra['mail'],
            'is_pickup' => false,
            'is_delivery' => false,
            'is_headquarter' => $isHeadquarter,
            'is_billing' => $isBilling,
        ];

        $this->validate($addressArray);

        $address = TmsOrderAddress::create($addressArray);

        return $address;
    }

    /**
     * Validates the address data from Pamyra.
     *
     * @param array $addressPamyra
     * @return void
     */
    private function validate(array $addressPamyra): void
    {
        // Validate the data
        $validator = Validator::make($addressPamyra, $this->validationRules);

        // Throw an exception if validation fails
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }
}