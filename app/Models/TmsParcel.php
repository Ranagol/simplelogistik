<?php

namespace App\Models;

use App\Models\TmsOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TmsParcel extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_parcels";

    const PARCEL_TYPE = [
        'bulky goods', 
        'euro pallet', 
        'one-way pallet',
        'cardboard',
        'pallet cage'
    ];

    protected $casts = [
        'is_hazardous' => 'boolean',
        'p_stackable' => 'boolean',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(TmsOrder::class, 'order_id');
    }
}
