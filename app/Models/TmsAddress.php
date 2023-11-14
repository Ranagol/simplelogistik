<?php

namespace App\Models;

use App\Models\TmsCustomer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsAddress extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_addresses";

    public function customer(): BelongsTo
    {
        return $this->belongsTo(TmsCustomer::class);
    }

    public function forwarder(): BelongsTo
    {
        return $this->belongsTo(TmsForwarder::class);
    }
}
