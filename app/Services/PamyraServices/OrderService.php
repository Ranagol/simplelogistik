<?php

namespace App\Services\PamyraServices;

use DateTime;
use App\Models\TmsOrder;
use App\Models\TmsCustomer;
use App\Models\TmsOrderStatus;
use App\Models\TmsPamyraOrder;
use App\Http\Requests\TmsOrderRequest;
use Illuminate\Support\Facades\Validator;
use App\Services\PamyraServices\OrderNumberMakerTrait;

class OrderService {

    use OrderNumberMakerTrait;

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
        //TODO ANDOR ask C. - FROSEN
        //STOP WITH THIS TASK, THIS CAN BE ONLY DONE WE CHRISTOPH PUSHES HIS CHANGES
        //in the moment that I am looking on the pamyra json I see there is a field with oderPdf. 
        //The data from this field schould go to (base_path).documents.orders.pamyra  name of File then $orderNumer .".pdf"

        $this->checkForDuplicate(
            $pamyraOrder, 
            $customerId, 
            $billingAddressId
        );

        $order = $this->createOrder(
            $pamyraOrder, 
            $customerId, 
            $billingAddressId,
            $partnerId
        );

        return $order;
    }

    /**
     * The only way to check for duplicate is to check if the order number already exists in the
     * tms_pamyra_orders table. (Not in tms_orders table!)
     * 
     * To test for duplicate, use this order number: PAM220826-1323140813
     *
     * @param array $pamyraOrder
     * @param integer $customerId
     * @param integer $billingAddressId
     * @return void
     */
    private function checkForDuplicate(array $pamyraOrder, int $customerId, int $billingAddressId)
    {
        $duplicateOrder = TmsPamyraOrder::where('order_number', $pamyraOrder['orderNumber'])->first();

        if($duplicateOrder) {
            echo 'Order with order number ' . $pamyraOrder['orderNumber'] . ' already exists.' . PHP_EOL;
            throw new \Exception('Order with order number ' . $pamyraOrder['orderNumber'] . ' already exists.');
        }
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
            //this is 'Order created. This is the first status of the order, returned with array_key_first
            'order_status_id' => array_key_first(TmsOrderStatus::STATUSES), 
            'provision' => 6,
            'currency' => 'EUR',
            'order_date' => $this->formatOrderDate($pamyraOrder['dateOfSale']),
            'purchase_price' => $pamyraOrder['priceNet'],
            'payment_method' => 5, //this is invoice payment method
            'billing_address_id' => $billingAddressId,
            'order_number' => $this->setOrderNumber(),
        ];

        $this->validate($orderArray);

        $order = TmsOrder::create($orderArray);

        return $order;
    }

    /**
     * Formats the order date from d.m.Y H:i to Y-m-d H:i:s
     *
     * @param string $orderDate
     * @return string
     */
    private function formatOrderDate(string $orderDate): string
    {
        //Create a DateTime object from string
        $date = DateTime::createFromFormat('d.m.Y H:i', $orderDate);

        //Add the missing seconds to the formatting, because mysql needs this
        $formattedDate = $date->format('Y-m-d H:i:s');
        return $formattedDate;
    }

    /**
     * Validates the order data.
     * 
     * @Christoph said, that temporarily we just need to throw a simple basic exception if the 
     * validation fails. Later we will handle this with monitoring.
     *
     * @param array $orderArray
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