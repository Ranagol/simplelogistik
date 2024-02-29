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

    public const PARCEL_TYPES = [//OLD, to be removed
        'bulky goods', 
        'euro pallet', 
        'one-way pallet',
        'cardboard',
        'pallet cage'
    ];

    private static $allParcelTypes = [//NEW
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

    //******************RELATIONSHIPS********************** */


    public function parcels(): HasMany
    {
        return $this->hasMany(TmsParcel::class, 'parcel_type_id');
    }


    //******************GETTERS********************** */

    /**
     * Get the value of allParcelTypes. Althoug this is a nested array, we return a simple array of
     * strings, which are the parcel types.
     * 
     * @return array
     */ 
    public static function getAllParcelTypes(): array
    {
        $allParcelTypes = [];

        foreach (self::$allParcelTypes as $parcelType => $value) {
            $allParcelTypes[] = $parcelType;
        }

        return $allParcelTypes;
    }

    /**
     * Get the value of only those parcel types that have 'true' in the 'display' key. True in this 
     * case is for, yes, display the parcel type in the front-end.
     * Althoug this is a nested array, we return a simple array of
     * strings, which are the parcel types.
     * 
     * @return array
     */
    public static function getFrontendParcelTypes(): array
    {
        $frontendParcelTypes = [];

        foreach (self::$allParcelTypes as $parcelType => $value) {
            if ($value['display'] === true) {
                $frontendParcelTypes[] = $parcelType;
            }
        }
        return $frontendParcelTypes;
    }

}
