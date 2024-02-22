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

    public const PROVISIONS_FOR_SEEDINGS = [
        "INSERT INTO simplelogistik.tms_provisions (id, partner_id, sales_channel, value, max_provision_limit_eur, valid_from, valid_to, created_at, updated_at) VALUES(1, 1, 'Marketplace', 8.0, 80.0, '2023-01-01', '2025-12-31', '2024-02-22 13:27:43', '2024-02-22 13:27:43');",
        "INSERT INTO simplelogistik.tms_provisions (id, partner_id, sales_channel, value, max_provision_limit_eur, valid_from, valid_to, created_at, updated_at) VALUES(2, 1, 'PRO', 6.0, 60.0, '2023-01-01', '2025-12-31', '2024-02-22 13:27:43', '2024-02-22 13:27:43');",
        "INSERT INTO simplelogistik.tms_provisions (id, partner_id, sales_channel, value, max_provision_limit_eur, valid_from, valid_to, created_at, updated_at) VALUES(3, 1, 'Sales Assistant', NULL, 0.95, '2023-01-01', '2025-12-31', '2024-02-22 13:27:43', '2024-02-22 13:27:43');",
        "INSERT INTO simplelogistik.tms_provisions (id, partner_id, sales_channel, value, max_provision_limit_eur, valid_from, valid_to, created_at, updated_at) VALUES(4, 1, 'Connect', NULL, 0.95, '2023-01-01', '2025-12-31', '2024-02-22 13:27:43', '2024-02-22 13:27:43');",
        "INSERT INTO simplelogistik.tms_provisions (id, partner_id, sales_channel, value, max_provision_limit_eur, valid_from, valid_to, created_at, updated_at) VALUES(5, 1, '4You', NULL, 0.95, '2023-01-01', '2025-12-31', '2024-02-22 13:27:43', '2024-02-22 13:27:43');",
    ];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(TmsPartner::class, 'partner_id');
    }
}
