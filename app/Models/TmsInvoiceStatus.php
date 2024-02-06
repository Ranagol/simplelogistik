<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsInvoiceStatus extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'tms_invoice_statuses';

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

    public function invoices(): HasMany
    {
        return $this->hasMany(TmsInvoice::class, 'invoice_status_id');
    }

}
