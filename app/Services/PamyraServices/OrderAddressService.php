<?php

namespace App\Services\PamyraServices;

use App\Models\TmsOrderAddress;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TmsOrderAddressRequest;
use Illuminate\Support\Facades\Validator;

class OrderAddressService {

    use DateFormatterTrait;

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
     * @param array $customer       This is either sender (for pickup) or receiver (for delivery).
     * @param array $date           This is either pickupDate or deliveryDate in Pamyra order, and contains all pickup or delivery details
     * @param integer $orderId
     * @param integer $customerId
     * @param integer $partnerId
     * @param string $addressType   pickup or delivery
     * @return void
     */
    public function handle(
        array $customer,
        array $date,
        int $orderId,
        int $customerId,
        int $partnerId,
        string $addressType//pickup or delivery
    ): void
    {
        $this->separateStreetAndHouseNumber($customer);

        $this->setCountryId($customer);
        
        $this->checkForDuplicate(
            $orderId,
            $customerId,
            $partnerId,
            $addressType,
        );

        $this->createAddress(
            $customer,
            $date,
            $orderId,
            $customerId,
            $partnerId,
            $addressType,
        );
    }

    /**
     * the addresses from orders from Pamyra have the street name and the house number together.  
     * Example:"street": "Am Hochhaus 70".
     * This must be separated into street and house number.
     * Source: https://stackoverflow.com/questions/7488557/separate-street-name-from-street-number
     * 
     * @param array $customer    This is either sender (for pickup) or receiver (for delivery).
     * 
     * @return void
     */
    private function separateStreetAndHouseNumber(array $customer): void
    {
        $streetAndNumber = $customer['Address']['Street'];//Example:"street": "Am Hochhaus 70".
        if (!preg_match('/^([^\d]*[^\d\s]) *(\d.*)$/', $streetAndNumber, $match)) {//Extract street and number
            throw new \Exception('Invalid address format');//If something is wrong with the extraction, throw an exception.
        }
        $this->street = $match[1];//Example:"Am Hochhaus".
        $this->houseNumber = $match[2];//Example:"70".
    }

    /**
     * Sets the country id from the country code.
     * 
     * @param array $customer    This is either sender (for pickup) or receiver (for delivery).
     *
     * @return void
     */
    private function setCountryId($customer): void
    {
        $countryCode = $customer['Address']['CountryCode'];
        $this->countryId = DB::table('tms_countries')->where('alpha2_code', $countryCode)->first()->id;
    }

    /**
     * Checks if there is a duplicate address in the database.
     * 
     * We must check here for 3 cases:
     * 1. isHeadquarter = true
     * 2. isBilling = true
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
            dump($duplicateAddress);
        }
    }

    /**
     * Creates an order address record in the database.
     *
     * @param array $customer
     * @param array $date
     * @param integer $orderId
     * @param integer $customerId
     * @param integer $partnerId
     * @param string $addressType
     * @return void
     */
    private function createAddress(
        array $customer,
        array $date,
        int $orderId,
        int $customerId,
        int $partnerId,
        string $addressType,
    ): void
    {
        $addressArray = [
            'order_id' => $orderId,
            'customer_id' => $customerId,
            'country_id' => $this->countryId,
            'partner_id' => $partnerId,
            'company_name' => $customer['Company'],
            'address_type' => $addressType,
            'first_name' => $customer['FirstName'],
            'last_name' => $customer['Name'],
            'street' => $this->street,
            'house_number' => $this->houseNumber,
            'zip_code' => $customer['Address']['PostalCode'],
            'city' => $customer['Address']['City'],
            'address_additional_information' => $customer['Address']['AddressAdditionalInformation'] ?? null,
            'phone' => $customer['Phone'],
            'email' => $customer['Mail'],
            'avis_phone' => $customer['AvisPhone'] ?? null,
            'date_from' => $this->formatPamyraDateTime(
                $date['DateFrom'],
                'd.m.Y',
                'Y-m-d'
            ),
            'date_to' => $this->formatPamyraDateTime(
                $date['DateTo'],
                'd.m.Y',
                'Y-m-d'
            ),
            'comments' => $date['AsString'],
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