<?php

namespace Modules\PamyraOrder\app\Services\PamyraServices;

use DateTime;
use Carbon\Carbon;
use App\Models\TmsOrder;
use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use App\Models\TmsOrderStatus;
use App\Models\TmsPamyraOrder;
use App\Models\TmsTransportRule;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\TmsOrderRequest;
use App\Models\TmsProvision;
use Illuminate\Support\Facades\Validator;
use Modules\PamyraOrder\app\Services\PamyraServices\DateFormatterTrait;
use Modules\PamyraOrder\app\Services\PamyraServices\OrderNumberMakerTrait;

class OrderService {

    use OrderNumberMakerTrait;
    use DateFormatterTrait;

    /**
     * Validation rules.
     * 
     * @var array
     */
    private array $validationRules;

    public function __construct()
    {
        /**
         * We copy here the validation rules from the TmsOrderRequest. Because we want to use them
         * in this class. And we can't use them directly from the TmsOrderRequest, because it is
         * a FormRequest. And we can't use a FormRequest in a class. So, we copy the rules here.
         */
        $tmsOrderRequest = new TmsOrderRequest();
        $this->validationRules = $tmsOrderRequest->orderRules();
    }

    /**
     * This is the main function in this class, that triggers all other functions.
     *
     * @param array $pamyraOrder
     * @param integer $customerId
     * @param integer $partnerId
     * @return TmsOrder
     */
    public function handle(
        array $pamyraOrder, 
        int $customerId, 
        int $partnerId
    ): TmsOrder
    {

        $order = $this->createOrder(
            $pamyraOrder, 
            $customerId, 
            $partnerId
        );

        return $order;
    }

    /**
     * Creates an order in the tms_orders table.
     *
     * @param array $pamyraOrder
     * @param integer $customerId
     * @param integer $partnerId
     * @return TmsOrder
     */
    private function createOrder(
        array $pamyraOrder,
        int $customerId,
        int $partnerId
    ): TmsOrder
    {
        $orderArray = [
            'customer_id' => $customerId,
            'partner_id' => $partnerId,
            'forwarder_id' => $this->setForwarderId($pamyraOrder),
            'origin' => TmsOrder::ORIGINS[1], //this is: pamyra
            'customer_reference' => $pamyraOrder['OrderNumber'] ?? 'missing Pamyra order number',
            //this is 'Order created. This is the first status of the order, returned with array_key_first
            'order_status_id' => array_key_first(TmsOrderStatus::STATUSES) ?? 1, 
            'provision' => $this->calculateProvisionInEur($pamyraOrder['PriceNet'] ?? null),
            'currency' => 'EUR',
            'order_date' => $this->formatPamyraDateTime($pamyraOrder['DateOfSale']),
            'purchase_price' => $pamyraOrder['PriceNet'] ?? null,
            'payment_method' => 5, //this is invoice payment method
            'order_number' => $this->setOrderNumber(),
            'import_file_name' => $this->createFileName($pamyraOrder),
        ];

        $this->validate($orderArray);

        $order = TmsOrder::create($orderArray);

        return $order;
    }

    /**
     * Validates the order data.
     * 
     * @Christoph said, that temporarily we just need to throw a simple basic exception if the 
     * validation fails. Later we will handle this with monitoring.
     *
     * @param array $orderArray
     * @throws \Exception
     * @return void
     */
    private function validate(array $orderArray): void
    {
        // Validate the data
        $validator = Validator::make($orderArray, $this->validationRules);

        // If the validation fails, throw an exception
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }

    /**
     * Creates a file name for the order. This file name will be stored in the tms_orders table, in
     * the import_file_name column. This is basically the archived version of the json file that
     * contained this order.
     * 
     * Example: 2024_02_19_PAM240206-1452140740.json
     * 2024_02_19 - this is the date when the record was created
     * PAM240206 - this is the order number from Pamyra
     *
     * @param array $pamyraOrder
     * @return string
     */
    private function createFileName(array $pamyraOrder): string
    {
        if($pamyraOrder['OrderNumber'] === null) {
            Log::alert('Missing Pamyra order number for order ' . $this->setOrderNumber());
            return 'Missing Pamyra order number for order ' . $this->setOrderNumber();
        }

        return Carbon::now()->format('Y_m_d') . '_' .  $pamyraOrder['OrderNumber'] . '.json';
    }

    /**
     * Gets the current valid provision from the tms_provisions table.
     * We handle here Pamyra orders. Pamyra is a partner with the id 1.
     * We use firstOrFail() because we want to throw an exception if we don't find the right provision.
     *
     * @return float
     */
    private function calculateProvisionInEur(float $priceNetEur): float
    {
        $currentDate = Carbon::now();

        $provision = TmsProvision::where('partner_id', 1)
                        ->where('valid_from', '<', $currentDate)
                        ->where('valid_to', '>', $currentDate)
                        ->where('sales_channel', 'Marketplace')
                        ->latest()
                        ->firstOrFail();

        $provisionPercentage = $provision->value;
        $maxProvisionLimitEur = $provision->max_provision_limit_eur;
        $provisionInEur = $priceNetEur * $provisionPercentage / 100;

        if($provisionInEur < $maxProvisionLimitEur) {
            return $provisionInEur;
        }
        return $maxProvisionLimitEur;
    }
    
    /*
     * Sets the forwarder id for the order. In general the forwarderId will be null. However,
     * if some setForwarder rule can be applied (from tms_transport_rules table), then we set the
     * forwarder id based on the rule.
     * 
     * @param array $pamyraOrder
     * @return int|null
     */
    private function setForwarderId(array $pamyraOrder): int | null
    {
        //Based on this string we decide who should be the forwarder for the given order.
        $calculationModelName = $pamyraOrder['CalculationModelName'] ?? null;
        $forwarderId = null;

        if($calculationModelName === null) {
            return $forwarderId;//which will be null. No need to continue the function.
        }

        //Get all rules for setting forwarder from db. 
        $rulesForSettingForwarder = TmsTransportRule::where('action_type', 'setForwarder')->get();

        //Loop through the rules and set the forwarder id
        foreach($rulesForSettingForwarder as $rule) {

            //Search for the keyphrase in the calculation model name
            if(strpos($calculationModelName, $rule->keyphrase) !== false) {
                $forwarderId = TmsForwarder::where('company_name', 'Emons')
                                            ->where('id', 1)
                                            ->firstOrFail()
                                            ->id;
                break;//if we found the forwarder, we don't need to continue the loop
            } 
        }

        return $forwarderId;
    }
}