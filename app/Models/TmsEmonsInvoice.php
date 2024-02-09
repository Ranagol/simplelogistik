<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmsEmonsInvoice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'tms_emons_invoices';

    protected $casts = [
        'billing_date' => 'date',
        'is_correct' => 'boolean',
    ];
}
