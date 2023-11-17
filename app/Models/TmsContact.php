<?php

namespace App\Models;

use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use App\Models\TmsCargoOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsContact extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_contacts";
    
    public function cargoOrders(): HasMany
    {
        return $this->hasMany(TmsCargoOrder::class, 'contact_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(TmsCustomer::class);
    }

    public function forwarder(): BelongsTo
    {
        return $this->belongsTo(TmsForwarder::class);
    }
}
