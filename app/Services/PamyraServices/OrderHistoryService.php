<?php

use App\Models\TmsOrderStatus;
use App\Models\TmsOrderHistory;

class OrderHistoryService {

    public function createOrderHistory(int $customerId, int $orderId): void
    {
        $orderHistory = new TmsOrderHistory();
        $orderHistory->order_status_id = TmsOrderStatus::STATUSES['created']; 
        $orderHistory->details = 'Order history created by handlePamyraOrders cron job';
        $orderHistory->additional_cost = 0;
        $orderHistory->order_id = $orderId;
        $orderHistory->forwarder_id = null;
        $orderHistory->customer_id = $customerId;
        $orderHistory->forwarding_contract_id = null;
        $orderHistory->user_id = null;//because this is not created by a user, created by cron job
        $orderHistory->cronjob_name = 'handlePamyraOrders';
        $orderHistory->save();
    }
}
