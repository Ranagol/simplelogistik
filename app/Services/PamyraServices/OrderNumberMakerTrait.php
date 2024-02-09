<?php

namespace App\Services\PamyraServices;

use App\Models\TmsOrder;
use App\Models\TmsPamyraOrder;

/**
 * Every order must have a unique order number. This trait handles this task. It does this by
 * simply getting the last order's order number and adding 1 to it. If there is no last order, then
 * it returns the start value of the order numbers + 1.
 */
trait OrderNumberMakerTrait {

    public function setOrderNumber()
    {
        $lastOrder = TmsOrder::orderBy('id', 'desc')->first();

        if ($lastOrder) {
            return $lastOrder->order_number + 1;
        }
        
        return TmsOrder::ORDER_NUMBER_START_VALUE + 1;
    }
}