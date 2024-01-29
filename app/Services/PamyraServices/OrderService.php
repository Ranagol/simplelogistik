<?php

namespace App\Services\PamyraServices;

use App\Models\TmsOrder;
use App\Http\Requests\TmsOrderRequest;
use App\Models\TmsCustomer;
use App\Models\TmsPamyraOrder;
use Illuminate\Support\Facades\Validator;
use DateTime;

class OrderService {

    /**
     * Validation rules.
     * This is just a temporary solution. We are supposed to use the OrderRequest class validation 
     * here. However, that is something that will be soon changed, because of the changes in the FE.
     * //TODO ANDOR
     * 
     * @var array
     */
    private array $validationRules = [
        'company_name' => ['nullable', 'string', 'max:255'],
        'contact_id' => ['nullable', 'integer'],
        'partner_id' => ['nullable', 'integer'],
        
        //ORDER VALIDATION (from orders table)
        'type_of_transport' => ['nullable', 'string', 'max:200'],
        'origin' => ['required', 'string', 'max:255'],
        'status' => ['required', 'string', 'max:255'],
        'customer_reference' => ['nullable', 'string', 'max:255'],
        'provision' => ['nullable', 'numeric', 'between:0,99.99'],
        'order_edited_events' => ['nullable', 'json'],
        'currency' => ['nullable', 'string', 'max:50'],
        'order_date' => ['required', 'date'],
        'purchase_price' => ['nullable', 'numeric'],
        'month_and_year' => ['nullable', 'string', 'max:255'],
        
        'avis_customer_phone' => ['nullable', 'string', 'max:200'],
        'avis_sender_phone' => ['nullable', 'string', 'max:200'],
        'avis_receiver_phone' => ['nullable', 'string', 'max:200'],
        
        'payment_method' => ['required', 'numeric'],
        'easy_bill_customer_id' => ['nullable', 'integer', 'min:1'],
    ];

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
        //TODO ANDOR: talk to Christoph about this. 
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
        //TODO ANDOR ask C., where should I write avis phones. Into order or, orderAddresses?
        //delete all 3 avis phone columns from orders
        //Add avis_phone column to OrderAddresses + faker. Change all related fakers, validators, etc.

        //TODO ANDOR ask C., should we use our order statuses or status.status from pamyra?
        //create order_statuses table. Check in Pamyra docs for statueses (how many, which type).Talk to C.
        //[PROVIDED_NOT_YET_ACCEPTED, CANCELED_BY_CUSTOMER, CANCELED_BY_AGENCY] ---- these three statuses we know. Are there more??


        //TODO ANDOR ask C., should we use our payment methods from customer model or pamyra payment methods? 
        //See notebook written ansers.
        /**
         * Make a table for this. Remove payment method mutator from TmsCustomer. Use this table.
         * The table should have something like Pamyra term - our term. For example:
         * bill = rechung
         * direct debit = sofort
         * preCashTransfer = Paypal
         * cashOnDelivery = leave our term empty here, write nothing
         * credit card = vorkasse
         */

        $orderArray = [
            'customer_id' => $customerId,
            'partner_id' => $partnerId,
            'origin' => TmsOrder::ORIGINS[1], //this is: pamyra
            'status' => TmsOrder::STATUSES[1], //this is 'Order created. 
            'provision' => 6,
            'currency' => 'EUR',
            'order_date' => $this->formatOrderDate($pamyraOrder['dateOfSale']),
            'purchase_price' => $pamyraOrder['priceNet'],
            'payment_method' => 5, //this is invoice payment method
            'billing_address_id' => $billingAddressId,
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
            //TODO ANDOR ask C., should we throw an exception or just echo the error? How to handle errors? 
            //YES, for now. Later we will handle this with monitoring
            /**
             * So, just write to every validation function this decision, for every service class.
             */
        }
    }
}