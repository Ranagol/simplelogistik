<?php

namespace Modules\PamyraOrder\app\Services\PamyraServices;

use DateTime;
use App\Models\TmsOrder;
use App\Models\TmsCustomer;
use App\Models\TmsOrderStatus;
use App\Models\TmsPamyraOrder;
use App\Http\Requests\TmsOrderRequest;
use Illuminate\Support\Facades\Validator;
use Modules\PamyraOrder\app\Services\PamyraServices\OrderNumberMakerTrait;
use Modules\PamyraOrder\app\Services\PamyraServices\DateFormatterTrait;

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
     * @param integer $billingAddressId
     * @param integer $partnerId
     * @return TmsOrder
     */
    public function handle(
        array $pamyraOrder, 
        int $customerId, 
        int $billingAddressId,
        int $partnerId
    ): TmsOrder
    {

        $order = $this->createOrder(
            $pamyraOrder, 
            $customerId, 
            $billingAddressId,
            $partnerId
        );

        return $order;
    }

    /**
     * Creates an order in the tms_orders table.
     *
     * @param array $pamyraOrder
     * @param integer $customerId
     * @param integer $billingAddressId
     * @param integer $partnerId
     * @return TmsOrder
     */
    private function createOrder(
        array $pamyraOrder,
        int $customerId,
        int $billingAddressId,
        int $partnerId
    ): TmsOrder
    {
        $orderArray = [
            'customer_id' => $customerId,
            'partner_id' => $partnerId,
            'origin' => TmsOrder::ORIGINS[1], //this is: pamyra
            'customer_reference' => $pamyraOrder['OrderNumber'] ?? 'missing Pamyra order number',
            //this is 'Order created. This is the first status of the order, returned with array_key_first
            'order_status_id' => array_key_first(TmsOrderStatus::STATUSES) ?? 1, 
            'provision' => 6,
            'currency' => 'EUR',
            'order_date' => $this->formatPamyraDateTime($pamyraOrder['DateOfSale']),
            'purchase_price' => $pamyraOrder['PriceNet'] ?? null,
            'payment_method' => 5, //this is invoice payment method
            'billing_address_id' => $billingAddressId,
            'order_number' => $this->setOrderNumber(),
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
}