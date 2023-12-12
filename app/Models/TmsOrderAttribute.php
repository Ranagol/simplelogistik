<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsOrderAttribute extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_order_attributes";

    public function cargoOrder(): BelongsTo
    {
        return $this->belongsTo(TmsCargoOrder::class, 'tms_cargo_order_id');
    }
}
