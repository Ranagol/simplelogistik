<?php

namespace App\Models;

use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use App\Models\TmsOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsOrderHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_order_histories";
    
    public function forwarder(): BelongsTo
    {
        return $this->belongsTo(TmsForwarder::class);
    }
    
    public function customer(): BelongsTo
    {
        return $this->belongsTo(TmsCustomer::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(TmsOrder::class);
    }

    public function forwardingContract(): BelongsTo
    {
        return $this->belongsTo(TmsForwardingContract::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
