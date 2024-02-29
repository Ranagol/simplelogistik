<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
