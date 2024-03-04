<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Example: the provision for Pamyra is 1.5% of the total price. This example 1.5% is the provision.
 */
class TmsProvision extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_provisions";

    /**
     * Pamyra has different sales channels and different provisions for each sales channel. The sales
     * channels are Marketplace, PRO, Sales Assistant, Connect, 4You. The provisions are 8.0%, 6.0%, 0.95%,
     * 0.95%, 0.95% respectively. So here we define this data, and use it to seed the database.
     */
    public const PROVISIONS_FOR_SEEDING = [
        [
            'partner_id' => 1,
            'sales_channel' => 'Marketplace',
            'value' => 8.0,
            'max_provision_limit_eur' => 80.0,
            'valid_from' => '2023-01-01',
            'valid_to' => '2025-12-31',
        ],
        [
            'partner_id' => 1,
            'sales_channel' => 'PRO',
            'value' => 6.0,
            'max_provision_limit_eur' => 60.0,
            'valid_from' => '2023-01-01',
            'valid_to' => '2025-12-31',
        ],
        [
            'partner_id' => 1,
            'sales_channel' => 'Sales Assistant',
            'value' => null,
            'max_provision_limit_eur' => 0.95,
            'valid_from' => '2023-01-01',
            'valid_to' => '2025-12-31',
        ],
        [
            'partner_id' => 1,
            'sales_channel' => 'Connect',
            'value' => null,
            'max_provision_limit_eur' => 0.95,
            'valid_from' => '2023-01-01',
            'valid_to' => '2025-12-31',
        ],
        [
            'partner_id' => 1,
            'sales_channel' => '4You',
            'value' => null,
            'max_provision_limit_eur' => 0.95,
            'valid_from' => '2023-01-01',
            'valid_to' => '2025-12-31',
        ],
    ];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(TmsPartner::class, 'partner_id');
    }
}
