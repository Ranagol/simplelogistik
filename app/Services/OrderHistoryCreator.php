<?php

namespace App\Services;

use App\Models\TmsOrder;
use App\Models\TmsOrderHistory;

class OrderHistoryCreator {

    /**
     * Undocumented function
     *
     * @param TmsOrder $order
     * @param string $action            store | update
     * @param integer|null $userId
     * @param string|null $cronJobName
     * @return void
     */
    public function createOrderHistory(
        TmsOrder $order,
        string $action,
        int $userId = null,
        string $cronJobName = null
    ): void
    {
        //Set, format data for order history
        $orderHistory = [
            'order_status_id' => 1,//we might need a dynamic getter here, because for update we need to get the new status
            'details' => $action,
            'additional_cost' => null,
            'order_id' => $order->id,
            'forwarder_id' => $order->forwarder_id,
            'customer_id' => $order->customer_id,
            'forwarding_contract_id' => null,//can we delete this column from the tms_order_histories? This info should not be stored here.
            'user_id' => $userId,
            'cron_job_name' => $cronJobName,
            'previous_state' => null,
        ];

        //Validate

        //Create a new order history
        TmsOrderHistory::create($orderHistory);
    }
}