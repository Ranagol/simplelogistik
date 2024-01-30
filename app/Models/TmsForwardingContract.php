<?php

namespace App\Models;

use App\Models\TmsVehicle;
use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TmsForwardingContract extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_forwarding_contracts";

    public function forwarder(): BelongsTo
    {
        return $this->belongsTo(TmsForwarder::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(TmsCustomer::class);
    }
    
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(TmsVehicle::class, 'vehicle_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderHistories(): HasMany
    {
        return $this->hasMany(TmsOrderHistory::class, 'forwarding_contract_id');
    }

    public function invoiceHistories(): HasMany
    {
        return $this->hasMany(TmsInvoiceHistory::class, 'forwarding_contract_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(TmsOrder::class, 'order_id');
    }
}
