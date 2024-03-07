<?php

namespace App\Services;

use App\Models\TmsOrder;
use App\Models\TmsOrderHistory;

class OrderHistoryCreator {

    /**
     * Undocumented function
     *
     * @param [type] $order
     * @param [type] $action
     * @param [type] $user
     * @return void
     */
    public function createOrderHistory(
        TmsOrder $order,
        string $action,
        int $userId,
        string $cronJobName
    ): void
    {
        $orderHistory = new TmsOrderHistory();
        $orderHistory->order_id = $order->id;
        $orderHistory->action = $action;
        $orderHistory->user_id = $user->id;
        $orderHistory->save();
    }
}