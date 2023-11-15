<?php

namespace App\Models;

use App\Models\TmsForwarder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsTransportLicense extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_transport_licenses";

    public function forwarder(): BelongsTo
    {
        return $this->belongsTo(TmsForwarder::class);
    }
}
