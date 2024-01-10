<?php

namespace App\Models;

use App\Models\TmsOrder;
use App\Models\TmsCountry;
use App\Models\TmsPartner;
use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Address in general belong to a customer. Every customer has his own usual address where/from he
 * usually sends his packages. When we have a specific order, then we select from these addresses
 * the pickup and delivery address. These two special address will from this moment belong to the
 * given order too. These two address ids will be stored in the orders table. Because they are so
 * important.
 */
class TmsAddress extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_addresses";

    /**
     * APPENDING (attaching a new column to the model, that is originally not in the model's table)
     * Here we want to add country_name to the Address model.
     *
     * @var array
     */
    protected $appends = ['country_name'];
    public function getCountryNameAttribute(): string
    {
        $country = TmsCountry::find($this->country_id);//$this->country_id is the country_id of the current Address model.
        $countryName = $country ? $country->country_name : 'TmsAddress appends error.';
        return $countryName;
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(TmsCustomer::class);
    }

    public function forwarder(): BelongsTo
    {
        return $this->belongsTo(TmsForwarder::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(TmsCountry::class, 'country_id');
    }





    public function partner(): BelongsTo
    {
        return $this->belongsTo(TmsPartner::class);
    }

    //*************SCOPES*************************************** */

    /**
     * This here is a Laravel local scope, for searching by search term.
     * https://laravel.com/docs/10.x/eloquent#local-scopes
     *
     * @param Builder $query
     * @param string $searchTerm
     * @return Builder
     */
    public function scopeSearchBySearchTerm(Builder $query, string $searchTerm): Builder
    {
        return $query->where('first_name', 'like', "%{$searchTerm}%")
            ->orWhere('last_name', 'like', "%{$searchTerm}%")
            ->orWhere('street', 'like', "%{$searchTerm}%")
            ->orWhere('city', 'like', "%{$searchTerm}%")
            ->orWhere('state', 'like', "%{$searchTerm}%")
            ;
    }

    //*************MUTATORS AND ACCESSORS*************************************** */

    
    /**
     * Mutator and accessor for the country_id db column. It is used to transform the data that is 
     * being retrieved from the database. In this case, we're using it to transform the country_id
     * integer value into a string representation. It must be called countryId, because the db column
     * is country_id.
     * 
     * get example: 1 will become 'Austria'.
     * set example: 'Austria' will become 1.
     * 
     *
     * @return Attribute
     */
    // protected function countryId(): Attribute
    // {
    //     return Attribute::make(

    //         /**
    //          * Here we return the country_name, instead of the country_id.
    //          */
    //         get: function (string $value) {
    //             $country = TmsCountry::find($value);
    //             $countryName = $country ? $country->country_name : 'Missing data TmsAddress model.';
    //             // dd($countryName);
    //             return $countryName;
    //         },

    //         /**
    //          * Here we return the country_id, instead of the country_name. Because we must write the
    //          * country_id into the db.
    //          */
    //         set: function (string $value) { 
    //             // dump($value);
    //             $countryId = TmsCountry::where('country_name', $value)->first()->id;
    //             // dd($value, $countryId);
    //             return $countryId;
    //         }
    //     );
    // }
}

