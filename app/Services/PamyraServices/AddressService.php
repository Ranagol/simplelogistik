<?php

namespace App\Services\PamyraServices;

use App\Models\TmsAddress;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TmsAddressRequest;
use Illuminate\Support\Facades\Validator;

class AddressService {

    private string $houseNumber;
    private string $street;
    private int $countryId;
    private int $partnerId;

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
         */
        $tmsAddressRequest = new TmsAddressRequest();
        $this->validationRules = $tmsAddressRequest->addressRules();
    }


    /**
     * This is the main function in this class, that triggers all other functions.
     *
     * @param array $customerPamyra
     * @param boolean $isHeadquarter
     * @param boolean $isBilling
     * @param integer $customerId
     * @return TmsAddress|null
     */
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
            $isHeadquarter,
            $isBilling,
            $customerId
        );

        //If there is a duplicate in db
        if( $duplicateAddress !== null) {
            return $duplicateAddress;
        } 

        $address = $this->createAddress(
            $customerPamyra, 
            $isHeadquarter, 
            $isBilling, 
            $customerId
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
        int $customerId
    ): TmsAddress | null
    {
        $duplicateAddress = TmsAddress::where('street', $this->street)
                                ->where('house_number', $this->houseNumber)
                                ->where('country_id', $this->countryId)
                                ->where('partner_id', $this->partnerId)
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
     * @return TmsAddress
     */
    private function createAddress(
        array $customerPamyra,
        bool $isHeadquarter,
        bool $isBilling,
        int $customerId
    ): TmsAddress
    {
        $address = new TmsAddress();
        $address->customer_id = $customerId;
        $address->country_id = $this->countryId;
        $address->partner_id = $this->partnerId;
        $address->company_name = $customerPamyra['company'];
        $address->first_name = $customerPamyra['firstName'];
        $address->last_name = $customerPamyra['name'];
        $address->street = $this->street;
        $address->house_number = $this->houseNumber;
        $address->zip_code = $customerPamyra['address']['postalCode'];
        $address->city = $customerPamyra['address']['city'];
        $address->address_additional_information = $customerPamyra['address']['addressAdditionalInformation'];
        $address->phone = $customerPamyra['phone'];
        $address->email = $customerPamyra['mail'];
        $address->is_pickup = false;
        $address->is_delivery = false;
        $address->is_headquarter = $isHeadquarter;
        $address->is_billing = $isBilling;

        $this->validate($address->toArray());

        $address->save();//this will have the id

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