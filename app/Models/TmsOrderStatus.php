<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsOrderStatus extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'tms_order_statuses';

    /**
     * This is the status of the order. External name comes from Pamyra API.
     */
    public const STATUSES = [
        1 => [
            'internal_name' => 'Order created',
            'external_name' => '',
        ],
        2 => [
            'internal_name' => 'Waiting for forwarder',
            'external_name' => '',
        ],
        3 => [
            'internal_name' => 'Forwarder found',
            'external_name' => '',
        ],
        4 => [
            'internal_name' => 'Picked up',
            'external_name' => '',
        ],
        5 => [
            'internal_name' => 'Delivered',
            'external_name' => '',
        ],
        6 => [
            'internal_name' => 'Canceled by customer',
            'external_name' => 'CANCELED_BY_CUSTOMER',
        ],
        7 => [
            'internal_name' => 'Canceled by Simplelogistik',
            'external_name' => 'CANCELED_BY_AGENCY',
        ],
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(TmsOrder::class, 'order_status_id');
    }
}
