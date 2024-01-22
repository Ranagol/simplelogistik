<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsPamyraOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_pamyra_orders";

    public function order(): BelongsTo
    {
        return $this->belongsTo(TmsOrder::class, 'order_id');
    }
}
