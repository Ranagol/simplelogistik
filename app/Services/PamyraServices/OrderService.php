<?php

namespace App\Services\PamyraServices;

use App\Models\TmsOrder;
use Illuminate\Support\Facades\Validator;

class OrderService {

    public function handle(array $pamyraOrder, int $customerId, int $billingAddressId): TmsOrder
    {
        $this->checkForDuplicate($pamyraOrder, $customerId, $billingAddressId);
        $this->validate($pamyraOrder);
        $order = $this->createOrder($pamyraOrder);
        return $order;
    }

    private function checkForDuplicate(array $pamyraOrder, int $customerId, int $billingAddressId)
    {
        $duplicateOrder = TmsOrder::where('customer_id', $customerId)
                            ->where('order_number', $pamyraOrder['orderNumber'])
                            ->where('billing_address_id', $billingAddressId)
                            ->first();

        if($duplicateOrder) {
            echo 'Order with order number ' . $pamyraOrder['orderNumber'] . ' already exists.' . PHP_EOL;
            throw new \Exception('Order with order number ' . $pamyraOrder['orderNumber'] . ' already exists.');
        }
    }

    private function validate(array $pamyraOrder): void
    { 
        $rules = [
            
        ]
    }

    private function createOrder(array $pamyraOrder): TmsOrder
    {
        $order = TmsOrder::create([
            'order_number' => $pamyraOrder['order_number'],
            'customer_id' => $pamyraOrder['customer_id'],
            'sender_id' => $pamyraOrder['sender_id'],
            'receiver_id' => $pamyraOrder['receiver_id'],
            'order_date' => $pamyraOrder['order_date'],
            'order_type' => $pamyraOrder['order_type'],
            'order_origin' => $pamyraOrder['order_origin'],
            'order_pdf' => $pamyraOrder['order_pdf'],
            'order_attributes' => $pamyraOrder['order_attributes'],
            'parcels' => $pamyraOrder['parcels'],
            'pamyra_order' => $pamyraOrder['pamyra_order'],
            'order_addresses' => $pamyraOrder['order_addresses'],
        ]);

        return $order;
    }
    

}