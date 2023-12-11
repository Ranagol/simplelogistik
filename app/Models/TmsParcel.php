<?php

namespace App\Models;

use App\Models\TmsCargoOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TmsParcel extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_parcels";

    public function cargoOrder(): BelongsTo
    {
        return $this->belongsTo(TmsCargoOrder::class, 'tms_cargo_order_id');
    }
}
