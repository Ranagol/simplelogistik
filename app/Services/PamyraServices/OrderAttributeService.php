<?php

namespace App\Services\PamyraServices;

use App\Models\TmsOrder;
use App\Models\TmsCustomer;
use App\Models\TmsOrderAttribute;
use App\Http\Requests\TmsCustomerRequest;
use Illuminate\Support\Facades\Validator;

class OrderAttributeService {

    public function handle(array $pamyraOrder, TmsOrder $order): void
    {
        $orderAttributes = $pamyraOrder['attributes'];
        foreach($orderAttributes as $orderAttribute) {
            $this->connectOrderWithOrderAttribute($orderAttribute, $order);
        }
    }

    /**
     * Instead of classic create...() we have here connect...(). That is because here we work with
     * many-to-many relationship. So, we don't create a new order attribute, we just connect the
     * existing order attribute with the existing order.
     *
     * @param array $orderAttribute
     * @param integer $orderId
     * @return void
     */
    private function connectOrderWithOrderAttribute(array $orderAttribute, TmsOrder $order): void
    {
        //Find the order attribute by name
        $orderAttributeId = TmsOrderAttribute::where('name_from_partner', $orderAttribute['attribute'])
                                ->first()->id;

        if(!$orderAttributeId) {
            throw new \Exception('Order attribute not found');
        }

        $order->orderAttributes()->attach($orderAttributeId);
    }
}