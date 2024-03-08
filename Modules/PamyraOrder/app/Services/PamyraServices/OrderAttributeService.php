<?php

namespace Modules\PamyraOrder\app\Services\PamyraServices;

use App\Models\TmsOrder;
use App\Models\TmsCustomer;
use App\Models\TmsOrderAttribute;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\TmsCustomerRequest;
use Illuminate\Support\Facades\Validator;

class OrderAttributeService {

    /**
     * This is the main function in this class, that triggers all other functions.
     *
     * @param array $pamyraOrder
     * @param TmsOrder $order
     * @return void
     */
    public function handle(array $pamyraOrder, TmsOrder $order): void
    {
        $orderAttributes = $pamyraOrder['Attributes'];
        foreach($orderAttributes as $orderAttribute) {
            $this->connectOrderWithOrderAttribute($orderAttribute, $order);
        }
    }

    /**
     * Instead of classic create...() we have here connect...(). That is because here we work with
     * many-to-many relationship. So, we don't create a new order attribute, we just connect the
     * existing order attribute with the existing order. So, we don't need to validate the data here.
     *
     * @param array $orderAttribute
     * @param integer $orderId
     * @return void
     */
    private function connectOrderWithOrderAttribute(array $orderAttribute, TmsOrder $order): void
    {
        /**
         * Find the order attribute by name.
         * There is a trick here. There could be many order attributes with the same name, valid
         * from different time periods. So, we need to find the latest one. This is why we use
         * latest('created_at') here.
         */
        $orderAttributeId = TmsOrderAttribute::where('name_from_partner', $orderAttribute['Attribute'])
                                ->latest('created_at')
                                ->first()
                                ->id;

        if(!$orderAttributeId) {
            $message = 'Order attribute from Pamyra json data not found in our database! There is a new 
                order attribute in Pamyra json data! Please check all order attributes in our db, 
                and in Pamyra, see what is missing!';
            Log::error($message);
            echo $message;
        }

        //Connect the order with the order attribute in the order_order_attribute pivot table
        $order->orderAttributes()->attach($orderAttributeId);
    }
}
