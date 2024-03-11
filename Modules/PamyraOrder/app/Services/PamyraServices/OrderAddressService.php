<?php

namespace Modules\PamyraOrder\app\Services\PamyraServices;

use App\Models\TmsOrderAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\TmsOrderAddressRequest;

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
     * @param string $pamyraOrderNumber
     * @return void
     */
    public function handle(
        array $customer,
        array $date,
        int $orderId,
        int $customerId,
        int $partnerId,
        string $addressType,//pickup or delivery
        string $pamyraOrderNumber
    ): void
    {
        $this->separateStreetAndHouseNumber($customer, $pamyraOrderNumber);

        $this->setCountryId($customer);
        
        

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
     * @param string $pamyraOrderNumber
     * 
     * @return void
     */
    private function separateStreetAndHouseNumber(array $customer, string $pamyraOrderNumber): void
    {
        $streetAndNumber = $customer['Address']['Street'];//Example:"street": "Am Hochhaus 70".
        if (!preg_match('/^([^\d]*[^\d\s]) *(\d.*)$/', $streetAndNumber, $match)) {//Extract street and number
            
            //If the street and house number separation failed, log it.
            $errorMessage = 'Separating street and house failed in Pamyra order '
                            . $pamyraOrderNumber
                            . ' for street '
                            . $customer['Address']['Street'];

            //If something is wrong with the extraction, log it.
            Log::error($errorMessage);
            echo $errorMessage . PHP_EOL;

            //And then just simply write all into the street field.
            $this->street = $customer['Address']['Street'] ?? null;
            $this->houseNumber = '';
        } else {
            //If the street and house number separation was successful, set the street and house number.
            $this->street = $match[1];//Example:"Am Hochhaus".
            $this->houseNumber = $match[2];//Example:"70".
        }
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
        $isDuplicate = $this->checkForDuplicate(
            $orderId,
            $customerId,
            $partnerId,
            $addressType,
        );

        if($isDuplicate) {
            return;
        }

        $addressArray = [
            'order_id' => $orderId,
            'customer_id' => $customerId,
            'country_id' => $this->countryId,
            'partner_id' => $partnerId,
            'company_name' => $customer['Company'] ?? null,
            'address_type' => $addressType,
            'first_name' => $customer['FirstName'] ?? 'missing',
            'last_name' => $customer['Name'] ?? 'missing',
            'street' => $this->street ?? 'missing',
            'house_number' => $this->houseNumber ?? 'missing',
            'zip_code' => $customer['Address']['PostalCode'] ?? 'missing',
            'city' => $customer['Address']['City'] ?? 'missing',
            'address_additional_information' => $customer['Address']['AddressAdditionalInformation'] ?? 'missing',
            'phone' => $customer['Phone'] ?? 'missing',
            'email' => $customer['Mail'] ?? 'missing',
            'avis_phone' => $customer['AvisPhone'] ?? 'missing',
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
            'comments' => $date['AsString'] ?? 'missing',
        ];

        $this->validate($addressArray);

        TmsOrderAddress::create($addressArray);
    }

    /**
     * Checks if there is a duplicate address in the database.
     * 
     * @param integer $orderId
     * @param integer $customerId
     * @param integer $partnerId
     * @param string $addressType
     * @return bool
     */
    private function checkForDuplicate(
        int $orderId,
        int $customerId,
        int $partnerId,
        string $addressType
    ): bool
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
            echo 'Duplicate address found in order_addresses table, while trying to create a Pamyra order from Pamyra json file.';
            Log::alert('Duplicate address found in order_addresses table, while trying to create a Pamyra order from Pamyra json file..');
            return true;
        }

        return false;
    }

    /**
     * Validates the data from Pamyra.
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
            echo $validator->errors()->first() . PHP_EOL;
            Log::error($validator->errors()->first());
        }
    }
}