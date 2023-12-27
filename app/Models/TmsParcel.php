<?php

namespace App\Models;

use App\Models\TmsCargoOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TmsParcel extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_parcels";

    const PARCEL_TYPE = ['package', 'bulky goods', 'euro pallet', 'disposable pallet'];

    protected $casts = [
        'is_hazardous' => 'boolean',
        'p_stackable' => 'boolean',
    ];

    public function cargoOrder(): BelongsTo
    {
        return $this->belongsTo(TmsCargoOrder::class, 'tms_cargo_order_id');
    }
}
