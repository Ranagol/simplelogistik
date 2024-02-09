<?php

namespace App\Models;

use App\Models\TmsOrder;
use App\Models\TmsCustomer;
use App\Models\TmsInvoiceHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsInvoice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_invoices";

    public const INVOICE_TYPES = [
        1 => 'Invoice',
        2 => 'Credit',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(TmsOrder::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(TmsCustomer::class);
    }

    public function invoiceHistories(): HasMany
    {
        return $this->hasMany(TmsInvoiceHistory::class, 'invoice_id');
    }

    public function invoiceStatus(): BelongsTo
    {
        return $this->belongsTo(TmsInvoiceStatus::class, 'invoice_status_id');
    }
}
