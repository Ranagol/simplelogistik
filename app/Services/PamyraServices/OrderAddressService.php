<?php

namespace App\Services\PamyraServices;

use App\Models\TmsOrderAddress;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TmsOrderAddressRequest;
use Illuminate\Support\Facades\Validator;

class OrderAddressService {

    private string $houseNumber;
    private string $street;
    private int $countryId;

    /**
     * Validation rules from TmsOrderAddressRequest.
     *
     * @var array
     */
    private array $validationRules;

    public function __construct()
    {
        /**
         * We copy here the validation rules from the TmsOrderAddressRequest. Because we want to use them
         * in this class. And we can't use them directly from the TmsOrderAddressRequest, because it is
         * a FormRequest. And we can't use a FormRequest in a class. So, we copy the rules here.
         */
        $tmsOrderAddressRequest = new TmsOrderAddressRequest();
        $this->validationRules = $tmsOrderAddressRequest->orderAddressRules();
    }

    /**
     * This is the main function in this class, that triggers all other functions.
     *
     * @param array $pamyraOrder
     * @param integer $orderId
     * @param integer $customerId
     * @param integer $partnerId
     * @param string $customerType  This is either sender (for pickup) or receiver (for delivery).
     * @param string $addressType
     * @return void
     */
    public function handle(
        array $pamyraOrder,
        int $orderId,
        int $customerId,
        int $partnerId,
        string $customerType,
        string $addressType//pickup or delivery
    ): void
    {
        $this->separateStreetAndHouseNumber(
            $pamyraOrder, 
            $customerType
        );

        $this->setCountryId(
            $pamyraOrder,
            $customerType
        );
        
        $this->checkForDuplicate(
            $orderId,
            $customerId,
            $partnerId,
            $addressType,
        );

        $this->createAddress(
            $pamyraOrder, 
            $orderId,
            $customerId,
            $partnerId,
            $addressType,
            $customerType
        );
    }

    /**
     * the addresses from orders from Pamyra have the street name and the house number together.  
     * Example:"street": "Am Hochhaus 70".
     * This must be separated into street and house number.
     * Source: https://stackoverflow.com/questions/7488557/separate-street-name-from-street-number
     * 
     * @param array $pamyraOrder
     * @param string $customerType  This is either sender (for pickup) or receiver (for delivery).
     * @return void
     */
    private function separateStreetAndHouseNumber(
        array $pamyraOrder, 
        string $customerType
    ): void
    {
        $streetAndNumber = $pamyraOrder[$customerType]['address']['street'];//Example:"street": "Am Hochhaus 70".
        if (!preg_match('/^([^\d]*[^\d\s]) *(\d.*)$/', $streetAndNumber, $match)) {//Extract street and number
            throw new \Exception('Invalid address format');//If something is wrong with the extraction, throw an exception.
        }
        $this->street = $match[1];//Example:"Am Hochhaus".
        $this->houseNumber = $match[2];//Example:"70".
    }

    /**
     * Sets the country id from the country code.
     *
     * @param array $pamyraOrder
     * @param string $customerType  This is either sender (for pickup) or receiver (for delivery).
     * @return void
     */
    private function setCountryId(
        array $pamyraOrder,
        string $customerType
    ): void
    {
        $countryCode = $pamyraOrder[$customerType]['address']['countryCode'];
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
     * @param array $pamyraOrder
     * @param boolean $isHeadquarter
     * @param boolean $isBilling
     * @param integer $customerId
     * @return void
     */
    private function checkForDuplicate(
        int $orderId,
        int $customerId,
        int $partnerId,
        string $addressType
    ): void
    {
        $duplicateAddress = TmsOrderAddress::where('street', $this->street)
                                ->where('house_number', $this->houseNumber)
                                ->where('country_id', $this->countryId)
                                ->where('order_id', $orderId)
                                ->where('partner_id', $partnerId)
                                ->where('customer_id', $customerId)
                                ->where('address_type', $addressType)
                                ->first();

        if($duplicateAddress) {
            throw new \Exception('Duplicate address found in order_addresses table.');
            dump('Duplicate address found in order_addresses table.');
            dump($duplicateAddress);
        }
    }

    /**
     * Creates an order address record in the database.
     *
     * @param array $pamyraOrder
     * @param integer $orderId
     * @param integer $customerId
     * @param integer $partnerId
     * @param string $addressType
     * @param string $customerType
     * @return void
     */
    private function createAddress(
        array $pamyraOrder,
        int $orderId,
        int $customerId,
        int $partnerId,
        string $addressType,
        string $customerType
    ): void
    {
        $addressArray = [
            'customer_id' => $customerId,
            'country_id' => $this->countryId,
            'partner_id' => $partnerId,
            'order_id' => $orderId,
            'company_name' => $pamyraOrder['company'],
            'address_type' => $addressType,
            'first_name' => $pamyraOrder['firstName'],
            'last_name' => $pamyraOrder['name'],
            'street' => $this->street,
            'house_number' => $this->houseNumber,
            'zip_code' => $pamyraOrder['address']['postalCode'],
            'city' => $pamyraOrder['address']['city'],
            'address_additional_information' => $pamyraOrder['address']['addressAdditionalInformation'],
            'phone' => $pamyraOrder['phone'],
            'email' => $pamyraOrder['mail'],

            'pickup_date_from' => $pamyraOrder['pickupDate']['dateFrom'],
            'pickup_date_to' => $pamyraOrder['pickupDate']['dateTo'],
            'pickup_comments' => $pamyraOrder['pickupDate']['asString'],
            'delivery_date_from' => $pamyraOrder['deliveryDate']['dateFrom'] ,
            'delivery_date_to' => $pamyraOrder['deliveryDate']['dateTo'],
            'delivery_comments' => $pamyraOrder['deliveryDate']['asString'],
        ];

        $this->validate($addressArray);

        TmsOrderAddress::create($addressArray);
    }

    /**
     * Validates the data from Pamyra.
     * 
     * @Christoph said, that temporarily we just need to throw a simple basic exception if the 
     * validation fails. Later we will handle this with monitoring.
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