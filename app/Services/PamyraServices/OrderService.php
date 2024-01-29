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


    public function handle(
        array $pamyraOrder, 
        int $customerId, 
        int $billingAddressId,
        int $partnerId
    ): TmsOrder
    {
        //TODO ANDOR: in the moment that I am looking on the pamyra json I see there is a field with oderPdf. The data from this field schould go to (base_path).documents.orders.pamyra  name of File then $orderNumer .".pdf"
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

    private function createOrder(
        array $pamyraOrder,
        int $customerId,
        int $billingAddressId,
        int $partnerId
    ): TmsOrder
    {
        $order = TmsOrder::create([
            'customer_id' => $customerId,
            'partner_id' => $partnerId,
            'origin' => TmsOrder::ORIGINS[1],//this is: pamyra
            'status' => TmsOrder::STATUSES[1],//this is 'Order created. //TODO ANDOR ask C., should we use our order statuses or status.status from pamyra?
            'provision' => 6,
            'currency' => 'EUR',
            'order_date' => $this->formatOrderDate($pamyraOrder['dateOfSale']),
            'purchase_price' => $pamyraOrder['priceGross'],//TODO ANDOR ask C, if this is good
            //TODO ANDOR ask C., where should I write avis phones. Into order or, orderAddresses?
            // 'payment_method' => TmsCustomer::PAYMENT_METHODS[5],//this is invoice //TODO ANDOR ask C., should we use our payment methods from customer model or pamyra payment methods?
            'payment_method' => 5,//this is invoice //TODO ANDOR ask C., should we use our payment methods from customer model or pamyra payment methods?
            
            'billing_address_id' => $billingAddressId,
        ]);

        $this->validate($order->toArray());//for validation we must transform model to array

        return $order;
    }

    private function formatOrderDate(string $orderDate): string
    {
        //Create a DateTime object from string
        $date = DateTime::createFromFormat('d.m.Y H:i', $orderDate);

        //Add the missing seconds to the formatting, because mysql needs this
        $formattedDate = $date->format('Y-m-d H:i:s');
        return $formattedDate;
    }

    private function validate(array $orderArray): void
    {
        // Validate the data
        $validator = Validator::make($orderArray, $this->validationRules);

        // If the validation fails, throw an exception
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
            //TODO ANDOR ask C., should we throw an exception or just echo the error? How to handle errors? 
        }
    }
}