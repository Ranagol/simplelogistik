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

    public const INVOICE_STATUSES = [
        1 => 'First warning',
        2 => 'Second warning',
        3 => 'Third warning',
        4 => 'Old invoice',
        5 => 'Compensation',
        6 => 'Paid',
        7 => 'Debt collection',
        8 => 'Mahnsperre',
        9 => 'Open',
        10 => 'Installment agreement',
        11 => 'Create account',
        12 => 'Chargeback/rückbuchung',
        13 => 'Appointments are announced by email or fax',
        14 => 'Irrecoverable/uneinbringlich',
        15 => 'Payment reminder',
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
}
