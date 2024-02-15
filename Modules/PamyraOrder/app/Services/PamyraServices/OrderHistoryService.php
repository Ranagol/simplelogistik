<?php

namespace Modules\PamyraOrder\app\Services\PamyraServices;

use App\Models\TmsOrderStatus;
use App\Models\TmsOrderHistory;

class OrderHistoryService {

    /**
     * When the handlePamyraOrders cron job is running, during that this time this method creates an 
     * order history for each Pamyra order from the json files. This is done to keep track of the
     * order status changes.
     * 
     * $orderHistory->user_id = null;//because this is not created by a user, created by cron job
     * $orderHistory->cronjob_name = 'handlePamyraOrders';//because this is created by 
     * handlePamyraOrders cron job
     * 
     * @param string $customerId
     * @param integer $orderId
     * @return void
     */
    public function createOrderHistory(
        string $pamyraOrderNumber,
        string $customerId, 
        int $orderId
    ): void
    {
        $orderHistory = new TmsOrderHistory();
        $orderHistory->order_status_id = 1;//This is 'Order created' status
        $orderHistory->details = $pamyraOrderNumber . '. Order history created by handlePamyraOrders cron job';
        $orderHistory->additional_cost = 0;
        $orderHistory->order_id = $orderId;
        $orderHistory->forwarder_id = null;
        $orderHistory->customer_id = $customerId;
        $orderHistory->forwarding_contract_id = null;
        $orderHistory->user_id = null;
        $orderHistory->cronjob_name = 'handlePamyraOrders';
        $orderHistory->save();
    }
}
