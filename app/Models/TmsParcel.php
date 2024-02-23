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

    private static $allParcelTypes = [
        'bulky goods' => [
            'display' => false
        ],
        'euro pallet' => [
            'display' => true
        ],
        'one-way pallet' => [
            'display' => true
        ],
        'cardboard' => [
            'display' => false
        ],
        'pallet cage' => [
            'display' => false
        ]
    ];

    protected $casts = [
        'is_hazardous' => 'boolean',
        'p_stackable' => 'boolean',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(TmsOrder::class, 'tms_order_id');
    }

    /**
     * Get the value of allParcelTypes.
     * 
     * @return array
     */ 
    public static function getAllParcelTypes(): array
    {
        return self::$allParcelTypes;
    }

    /**
     * Get the value of only those parcel types that have 'true' in the 'display' key. True in this 
     * case is for, yes, display the parcel type in the front-end.
     * 
     * @return array
     */
    public static function getFrontendParcelTypes(): array
    {
        $allParcelTypes = self::getAllParcelTypes();
        $frontendParcelTypes = [];

        foreach ($allParcelTypes as $parcelType => $value) {
            if ($value['display'] === true) {
                $frontendParcelTypes[] = $parcelType;
            }
        }
        return $frontendParcelTypes;
    }
}
