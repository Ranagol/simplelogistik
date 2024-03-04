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

    // public const PARCEL_TYPES = [//OLD, to be removed
    //     'bulky goods', 
    //     'euro pallet', 
    //     'one-way pallet',
    //     'cardboard',
    //     'pallet cage'
    // ];

    /**
     * All parcel types.
     * A list of Pamyra parcel types can be found here: https://www.pamyra.de/app?step=2
     *
     * @var array
     */
    private static $allParcelTypes = [//NEW
        [
            'id' => 1,
            'parcelType' => 'bulky goods',
            'display' => false,
            'pamyraName' => 'none'
        ],
        [
            'id' => 2,
            'parcelType' => 'euro pallet',
            'display' => true,
            'pamyraName' => 'EUR-Palette'
        ],
        [
            'id' => 3,
            'parcelType' => 'one-way pallet',
            'display' => true,
            'pamyraName' => 'Einweg-Palette'
        ],
        [
            'id' => 4,
            'parcelType' => 'cardboard',
            'display' => false,
            'pamyraName' => 'none'
        ],
        [
            'id' => 5,
            'parcelType' => 'pallet cage',
            'display' => false,
            'pamyraName' => 'EUR-Gitterbox'
        ],
        [
            'id' => 6,
            'parcelType' => 'missing palett info',
            'display' => false,
            'pamyraName' => 'none'
        ],
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
     * @return array    Array of all parcel types.
     */ 
    public static function getAllParcelTypes(): array
    {
        $allParcelTypes = [];

        foreach (self::$allParcelTypes as $parcelType) {
            $allParcelTypes[] = $parcelType['parcelType'];
        }

        return $allParcelTypes;
    }

    /**
     * Get the value of only those parcel types that have 'true' in the 'display' key. True in this 
     * case is for, yes, display the parcel type in the front-end.
     * Althoug this is a nested array, we return a simple array of
     * strings, which are the parcel types.
     * 
     * @return array    Array of parcel type that are to be displayed in the front-end.
     */
    public static function getFrontendParcelTypes(): array
    {
        $frontendParcelTypes = [];

        foreach (self::$allParcelTypes as $parcelType) {
            if ($parcelType['display'] === true) {
                $frontendParcelTypes[] = $parcelType['parcelType'];
            }
        }
        return $frontendParcelTypes;
    }

    /**
     * Gets the parcel type id from the Simplelogistik parcel type name. Example: 'euro pallet'
     * will return 2.
     * If the function can't match the parcel type, it will return 6, which is the id for 'missing
     * palett info'.
     * 
     * For testing in Tinker:
     * App\Models\TmsParcelType::getParcelTypeIdSimplelogistik('bulky goods');
     * App\Models\TmsParcelType::getParcelTypeIdSimplelogistik('should fail');
     *
     * @param string|null     $simplelogistikParcelType
     * @return integer
     */
    public static function getParcelTypeIdSimplelogistik(string | null $simplelogistikParcelType): int
    {

        if ($simplelogistikParcelType === null) {
            return 6;//missing palett info
        }

        $filteredNestedArray = array_filter(
            self::$allParcelTypes,//loop throug this array...
            function ($parcel) use ($simplelogistikParcelType) {

                //and find the nested array that matches the parcel type
                return $parcel['parcelType'] === $simplelogistikParcelType;
            }
        );

        /**
         * The array_filter() function preserves keys by default, so the keys in $filteredArray 
         * will be the same as in the original $array. If you want to reindex the keys, you can use 
         * the array_values() function:
         */
        $filteredNestedArray = array_values($filteredNestedArray);

        //If there is a nested array, return the id of it
        if (isset($filteredNestedArray[0]) === true) {
            return $filteredNestedArray[0]['id'];//Example: for euro pallet, return 2
        }

        //... otherwise return 6, which is the id for 'missing palett info'
        return 6;//missing palett info
    }

    /**
     * Gets the parcel type id from the Pamyra parcel type name. Example: 'EUR-Palette'
     * will return 2.
     * 
     * For testing in Tinker:
     * App\Models\TmsParcelType::getParcelTypeIdPamyra('EUR-Palette');
     * App\Models\TmsParcelType::getParcelTypeIdPamyra('should fail');
     * 
     * If the function can't match the parcel type, it will return 6, which is the id for 'missing
     * palett info'.
     * 
     * @param string|null $parcelType
     * @return integer
     */
    public static function getParcelTypeIdPamyra(string|null $pamyraParcelType): int
    {
        if ($pamyraParcelType === null) {
            return 6;//missing palett info
        }

        $filteredNestedArray = array_filter(
            self::$allParcelTypes, 
            function ($parcel) use ($pamyraParcelType) {
                return $parcel['pamyraName'] === $pamyraParcelType;
            }
        );

        /**
         * The array_filter() function preserves keys by default, so the keys in $filteredArray 
         * will be the same as in the original $array. If you want to reindex the keys, you can use 
         * the array_values() function:
         */
        $filteredNestedArray = array_values($filteredNestedArray);

        //If there is a nested array, return the id of it
        if (isset($filteredNestedArray[0]) === true) {
            return $filteredNestedArray[0]['id'];//Example: for euro pallet, return 2
        }

        //... otherwise return 6, which is the id for 'missing palett info'
        return 6;//missing palett info
    }
}
