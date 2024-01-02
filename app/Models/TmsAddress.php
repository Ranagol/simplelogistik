<?php

namespace App\Models;

use App\Models\TmsCountry;
use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use App\Models\TmsCargoOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


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

    public function cargoOrdersByStartAddresses(): HasMany
    {
        return $this->hasMany(TmsCargoOrder::class, 'pickup_address_id');
    }

    public function cargoOrdersByTargetAddresses(): HasMany
    {
        return $this->hasMany(TmsCargoOrder::class, 'delivery_address_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(TmsCountry::class, 'country_id');
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
             * gets from request, transforms it. 'Bussiness address' will become 1.
             *
             * To implement the setter using the ADDRESS_TYPES constant, you need to flip the array
             * keys and values because you're mapping from the string representation back to the
             * integer value.
             * he set method uses array_flip to swap the keys and values of the ADDRESS_TYPES
             * constant, then looks up the integer value corresponding to the provided address type
             * string. If the string is not found in the flipped array, it defaults to 'Missing data.'.
             */
            // set: fn (string $value) => array_flip(self::ADDRESS_TYPES)[$value] ?? 'Missing data TmsAddress model.',
            set: function (string $value) {//the old way
                dd($value);
                return array_flip(self::ADDRESS_TYPES)[$value] ?? 'Missing data TmsAddress model.';
            }

        );
    }
}
