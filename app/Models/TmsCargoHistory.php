<?php

namespace App\Models;

use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use App\Models\TmsCargoOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsCargoHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_cargo_histories";
    
    public function forwarder(): BelongsTo
    {
        return $this->belongsTo(TmsForwarder::class);
    }



    //*
    public function customer(): BelongsTo
    {
        return $this->belongsTo(TmsCustomer::class);
    }

    public function cargoOrder(): BelongsTo
    {
        return $this->belongsTo(TmsCargoOrder::class);
    }

    public function forwardingContract(): BelongsTo
    {
        return $this->belongsTo(TmsForwardingContract::class);
    }
}
