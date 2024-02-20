<?php

namespace Modules\PamyraOrder\app\Services\PamyraServices;


use App\Models\TmsAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\TmsAddressRequest;
use Illuminate\Support\Facades\Validator;

class AddressService {

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
         */
        $tmsAddressRequest = new TmsAddressRequest();
        $this->validationRules = $tmsAddressRequest->addressRules();
    }

    /**
     * This is the main function in this class, that triggers all other functions.
     * @param array $pamyraOrder        Needed for details when there is an address issue
     * @param array $customerPamyra     Needed for creating an address.
     * @param boolean $isHeadquarter
     * @param boolean $isBilling
     * @param boolean $isPickup
     * @param boolean $isDelivery
     * @param integer $customerId
     * @return TmsAddress|null
     */
    public function handle(
        array $pamyraOrder,
        array $customerPamyra,
        bool $isHeadquarter,
        bool $isBilling,
        bool $isPickup,
        bool $isDelivery,
        int $customerId,
        int $partnerId
    ): TmsAddress | null
    {
        $this->separateStreetAndHouseNumber($pamyraOrder, $customerPamyra);
        $this->setCountryId($customerPamyra);
        
        $duplicateAddress = $this->checkForDuplicate(
            $isHeadquarter,
            $isBilling,
            $isPickup,
            $isDelivery,
            $customerId,
            $partnerId
        );

        //If there is a duplicate in db
        if( $duplicateAddress !== null) {
            return $duplicateAddress;
        } 

        $address = $this->createAddress(
            $customerPamyra, 
            $isHeadquarter, 
            $isBilling, 
            $isPickup,
            $isDelivery,
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
     * @param array $pamyraOrder
     * @param array $customerPamyra
     * @return void
     */
    private function separateStreetAndHouseNumber(array $pamyraOrder, array $customerPamyra): void
    {
        $streetAndNumber = $customerPamyra['Address']['Street'];//Example:"street": "Am Hochhaus 70".

        //Extract street and number. The $match is an result array containting the street and the number after regex is done.
        if (!preg_match('/^([^\d]*[^\d\s]) *(\d.*)$/', $streetAndNumber, $match)) {

            //If something is wrong with the extraction display it. log it.
            $message = 'Regex street extraction failed. PamyraOrder: ' . $pamyraOrder['OrderNumber']
                        . ' Possible issue source: ' . $streetAndNumber
                        . PHP_EOL;
            echo $message;
            Log::error($message);
        }
        $this->street = $match[1] ?? $streetAndNumber;//Example:"Am Hochhaus".
        $this->houseNumber = $match[2] ?? $streetAndNumber;//Example:"70".
    }

    /**
     * Sets the country id from the country code.
     *
     * @param array $customerPamyra
     * @return void
     */
    private function setCountryId(array $customerPamyra): void
    {
        $countryCode = $customerPamyra['Address']['CountryCode'];
        $this->countryId = DB::table('tms_countries')->where('alpha2_code', $countryCode)->first()->id;
    }

    /**
     * Checks if there is a duplicate address in the database.
     *
     * @param array $customerPamyra
     * @param boolean $isHeadquarter
     * @param boolean $isBilling
     * @param boolean $isPickup
     * @param boolean $isDelivery
     * @param integer $customerId
     * @param integer $partnerId
     * @return void
     */
    private function checkForDuplicate(
        bool $isHeadquarter,
        bool $isBilling,
        bool $isPickup,
        bool $isDelivery,
        int $customerId,
        int $partnerId
    ): TmsAddress | null
    {
        $duplicateAddress = TmsAddress::where('street', $this->street)
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
                                ->when($isPickup, function ($query) {
                                    return $query->where('is_pickup', true);
                                })
                                ->when($isDelivery, function ($query) {
                                    return $query->where('is_delivery', true);
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
     * @param boolean $isPickup
     * @param boolean $isDelivery
     * @param integer $customerId
     * @return TmsAddress
     */
    private function createAddress(
        array $customerPamyra,
        bool $isHeadquarter,
        bool $isBilling,
        bool $isPickup,
        bool $isDelivery,
        int $customerId,
        int $partnerId
    ): TmsAddress
    {
        $addressArray = [
            'customer_id' => $customerId,
            'country_id' => $this->countryId,
            'partner_id' => $partnerId,
            'company_name' => $customerPamyra['Company'] ?? null,
            'first_name' => $customerPamyra['FirstName'] ?? 'missing',
            'last_name' => $customerPamyra['Name'] ?? 'missing',
            'street' => $this->street ?? 'missing',
            'house_number' => $this->houseNumber ?? 'missing',
            'zip_code' => $customerPamyra['Address']['PostalCode'] ?? 'missing',
            'city' => $customerPamyra['Address']['City'] ?? 'missing',
            'phone' => $customerPamyra['Phone'] ?? 'missing',
            'email' => $customerPamyra['Mail'] ?? 'missing',
            'is_headquarter' => $isHeadquarter,
            'is_billing' => $isBilling,
            'is_pickup' => $isPickup,
            'is_delivery' => $isDelivery,
            
        ];

        $this->validate($addressArray);

        $address = TmsAddress::create($addressArray);

        return $address;
    }

    /**
     * Validates the address data from Pamyra.
     * 
     * @Christoph said, that temporarily we just need to throw a simple basic exception if the 
     * validation fails. Later we will handle this with monitoring.
     *
     * @param array $addressPamyra
     * @throws \Exception
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