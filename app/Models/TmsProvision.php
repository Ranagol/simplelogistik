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

    public function partner(): BelongsTo
    {
        return $this->belongsTo(TmsPartner::class, 'partner_id');
    }
}
