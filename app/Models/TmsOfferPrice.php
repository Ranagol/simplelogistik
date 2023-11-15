<?php

namespace App\Models;

use App\Models\TmsForwarder;
use App\Models\TmsCargoOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsOfferPrice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_offer_prices";

    public function forwarder(): BelongsTo
    {
        return $this->belongsTo(TmsForwarder::class);
    }

    public function cargoOrder(): BelongsTo
    {
        return $this->belongsTo(TmsCargoOrder::class);
    }
}
