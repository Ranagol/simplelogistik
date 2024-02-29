<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TmsParcelType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_parcel_types";

    public const PARCEL_TYPES = [
        'bulky goods', 
        'euro pallet', 
        'one-way pallet',
        'cardboard',
        'pallet cage'
    ];

    public function parcels(): HasMany
    {
        return $this->hasMany(TmsParcel::class, 'parcel_type_id');
    }
}
