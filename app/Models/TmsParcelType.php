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

    /**
     * All parcel types.
     * A list of Pamyra parcel types can be found here: https://www.pamyra.de/app?step=2
     * 
     * parcelTypeSimplelogistik - this is our name for the parcel type in Simplelogistik
     * display - if true, the parcel type will be displayed in the front-end
     * parcelTypePamyra - this is the name of the parcel type in Pamyra
     
     *
     * @var array
     */
    private static $allParcelTypes = [
        [
            'id' => 1,
            'parcelTypeSimplelogistik' => 'bulky goods',
            'display' => false,
            'parcelTypePamyra' => []
        ],
        [
            'id' => 2,
            'parcelTypeSimplelogistik' => 'euro pallet',
            'display' => true,
            'parcelTypePamyra' => [
                'EUR-Palette',
                'EUR-Palette mit Überhang',
            ]
        ],
        [
            'id' => 3,
            'parcelTypeSimplelogistik' => 'one-way pallet',
            'display' => true,
            'parcelTypePamyra' => [
                'Einweg-Palette',
                'ENP Palette (nicht tauschbar)',
                'Halbpalette',
                'Industriepalette',
                'Sonstige / Eigene Maße (palettiert)',
            ]
        ],
        [
            'id' => 4,
            'parcelTypeSimplelogistik' => 'cardboard',
            'display' => false,
            'parcelTypePamyra' => [
                'Fahrrad (im Karton)',
                'E-Bike (im Karton)',
                'Sonstige / Eigene Maße (nicht palettiert)',
                'Paket',
                'Stück / loses Stückgut (nicht palettiert)',
            ]
        ],
        [
            'id' => 5,
            'parcelTypeSimplelogistik' => 'pallet cage',
            'display' => false,
            'parcelTypePamyra' => 'EUR-Gitterbox'
        ],
        [
            /**
             * This is a catch-all for when we can't match the parcel type.
             */
            'id' => 6,
            'parcelTypeSimplelogistik' => 'missing palett info',
            'display' => false,
            'parcelTypePamyra' => []
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
     * strings, which are the parcel types (names used in Simplelogistik).
     * This is used in seeders and factories.
     * 
     * @return array    Array of all parcel types.
     */ 
    public static function getAllParcelTypes(): array
    {
        $allParcelTypes = [];

        foreach (self::$allParcelTypes as $parcelType) {
            $allParcelTypes[] = $parcelType['parcelTypeSimplelogistik'];
        }

        return $allParcelTypes;
    }

    /**
     * Get the value of only those parcel types that have 'true' in the 'display' key. True in this 
     * case is for, yes, display the parcel type in the front-end.
     * Althoug this is a nested array, we return a simple array of
     * strings, which are the parcel types.
     * This is used to send parcel types to the front-end.
     * 
     * @return array    Array of parcel type that are to be displayed in the front-end.
     */
    public static function getFrontendParcelTypes(): array
    {
        $frontendParcelTypes = [];

        foreach (self::$allParcelTypes as $parcelType) {
            if ($parcelType['display'] === true) {
                $frontendParcelTypes[] = $parcelType['parcelTypeSimplelogistik'];
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
     * This is used to get the parcel type id from the name of the parcel type in Simplelogistik.
     * 
     * For testing in Tinker:
     * App\Models\TmsParcelType::getParcelTypeIdSimplelogistik('bulky goods');//1
     * App\Models\TmsParcelType::getParcelTypeIdSimplelogistik('should fail');//6
     *
     * @param string|null     $simplelogistikParcelType
     * @return integer
     */
    public static function getParcelTypeIdSimplelogistik(string | null $simplelogistikParcelType): int
    {
        //This is a guard clause, because Simplelogistik might not provide a parcel type
        if ($simplelogistikParcelType === null) {
            return self::getMissingParcelTypeId();//missing palett id = 6
        }

        $parcelTypeId = null;

        //Loop over all parcel types
        foreach (self::$allParcelTypes as $type) {//1 level deep
            if ($type['parcelTypeSimplelogistik'] === $simplelogistikParcelType) {
                $parcelTypeId = $type['id'];
            }
        }

        if ($parcelTypeId !== null) {

            //If we found a match, return the id of the parcel type. This is the id we need
            return $parcelTypeId;
        }

        //... otherwise return 6, which is the id for 'missing palett info'
        return self::getMissingParcelTypeId();
    }

    /**
     * Gets the parcel type id from the Pamyra parcel type name. Example: 'EUR-Palette'
     * will return 2.
     * 
     * This is used to get the parcel type id from the name of the parcel type in Pamyra. In ParcelService.php
     * 
     * For testing in Tinker:
     * App\Models\TmsParcelType::getParcelTypeIdPamyra('EUR-Palette');//2
     * App\Models\TmsParcelType::getParcelTypeIdPamyra('should fail');//6
     * App\Models\TmsParcelType::getParcelTypeIdPamyra('Sonstige / Eigene Maße (palettiert)');//3
     * 
     * If the function can't match the parcel type, it will return 6, which is the id for 'missing
     * palett info'.
     * 
     * @param string|null $parcelType
     * @return integer
     */
    public static function getParcelTypeIdPamyra(string|null $argument): int
    {
        //This is a guard clause, because Pamyra might not provide a parcel type
        if ($argument === null) {
            return self::getMissingParcelTypeId();
        }

        $parcelTypeId = null;

        foreach (self::$allParcelTypes as $type) {//1 level deep
            foreach(
                $type['parcelTypePamyra'] 
                as 
                $pamyraType) {//2 levels deep, looping over Pamyra types

                //Example (If EUR-Palette === EUR-Palette)
                if ($pamyraType === $argument) {

                    //We extract here the id of the parcel type. This is what we need
                    $parcelTypeId = $type['id'];
                }
            }
        }

        if ($parcelTypeId !== null) {

            //If we found a match, return the id of the parcel type. This is the id we need
            return $parcelTypeId;
        }

        //... otherwise return 6, which is the id for 'missing palett info'
        return self::getMissingParcelTypeId();
    }

    private static function getMissingParcelTypeId(): int
    {
        //Loop over all parcel types
        foreach (self::$allParcelTypes as $type) {//1 level deep
            if ($type['parcelTypeSimplelogistik'] === 'missing palett info') {
                return $type['id'];//this will be id = 6, the id for 'missing palett info'
            } 
        }
    }
}
