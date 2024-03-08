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
            'internal_name' => 'Neuer Auftrag',
            'external_name' => '',
        ],
        2 => [
            'internal_name' => 'In Disposition',
            'external_name' => '',
        ],
        3 => [
            'internal_name' => 'Disponiert',
            'external_name' => '',
        ],
        4 => [
            'internal_name' => 'Warten auf Kunde',
            'external_name' => '',
        ],
        5 => [
            'internal_name' => 'Zugestellt',
            'external_name' => '',
        ],
        6 => [
            'internal_name' => 'Storniert',
            'external_name' => 'CANCELED_BY_CUSTOMER or CANCELED_BY_AGENCY',
        ],
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(TmsOrder::class, 'order_status_id');
    }
}
