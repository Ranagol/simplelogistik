<?php

namespace App\Models;

use App\Models\TmsInvoice;
use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use App\Models\TmsForwardingContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsInvoiceHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_invoice_histories";

    public function forwarder(): BelongsTo
    {
        return $this->belongsTo(TmsForwarder::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(TmsCustomer::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(TmsInvoice::class, 'invoice_id');
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
