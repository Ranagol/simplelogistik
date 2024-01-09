<?php

namespace App\Models;

use App\Models\TmsCountry;
use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use App\Models\TmsOrder;
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

    public function address(): BelongsTo
    {
        return $this->belongsTo(TmsCustomer::class);
    }

    public function forwarder(): BelongsTo
    {
        return $this->belongsTo(TmsForwarder::class);
    }

    public function ordersByStartAddresses(): HasMany
    {
        return $this->hasMany(TmsOrder::class, 'pickup_address_id');
    }

    public function ordersByTargetAddresses(): HasMany
    {
        return $this->hasMany(TmsOrder::class, 'delivery_address_id');
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
     * Here we set the address type db column possible options. This array will be used during
     * seeding too. So, when you want to add a new address type, this is the place to do it.
     */
    const ADDRESS_TYPES = [
        1 => 'Main headquarters',
        2 => 'Billing address',
        3 => 'Pickup address',
        4 => 'Delivery address',
    ];

    /**
     * This is a Laravel accessor/mutator. It is used to transform the data that is being retrieved from the
     * database. In this case, we're using it to transform the address type integer value into a
     * string representation.
     * It must be called addressType, because the db column is address_type.
     * 
     * @return Attribute
     */
    protected function addressType(): Attribute
    {
        return Attribute::make(

            /**
             * Accessor
             * gets from db, transforms it. 1 will become 'Bussiness address'.
             * directly looks up the address type in the ADDRESS_TYPES constant using the provided
             * value. If the value is not found in the constant, it defaults to 'Missing data.'.
             */
            get: fn (string $value) => self::ADDRESS_TYPES[$value] ?? 'Missing data TmsAddress model.',

            /**
             * Mutator
             * gets from request, transforms it. 'Bussiness address' will become 2.
             *
             * To implement the setter using the ADDRESS_TYPES constant, you need to flip the array
             * keys and values because you're mapping from the string representation back to the
             * integer value.
             * he set method uses array_flip to swap the keys and values of the ADDRESS_TYPES
             * constant, then looks up the integer value corresponding to the provided address type
             * string. If the string is not found in the flipped array, it defaults to 'Missing data.'.
             */
            // set: fn (string $value) => array_flip(self::ADDRESS_TYPES)[$value] ?? 'Missing data TmsAddress model.',
            set: function (string $value) {//the old way, without arrow function
                // dd($value);
                return array_flip(self::ADDRESS_TYPES)[$value] ?? 'Missing data TmsAddress model.';
            }

        );
    }

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
    protected function countryId(): Attribute
    {
        return Attribute::make(

            /**
             * Here we return the country_name, instead of the country_id.
             */
            get: function (string $value) {
                $country = TmsCountry::find($value);
                $countryName = $country ? $country->country_name : 'Missing data TmsAddress model.';
                // dd($countryName);
                return $countryName;
            },

            /**
             * Here we return the country_id, instead of the country_name. Because we must write the
             * country_id into the db.
             */
            set: function (string $value) { 
                // dump($value);
                $countryId = TmsCountry::where('country_name', $value)->first()->id;
                // dd($value, $countryId);
                return $countryId;
            }
        );
    }
}

