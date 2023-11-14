<?php

namespace App\Models;

use App\Models\TmsCargoOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsInvoice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_invoices";

    public function cargoOrder(): BelongsTo
    {
        return $this->belongsTo(TmsCargoOrder::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(TmsCustomer::class);
    }
}
