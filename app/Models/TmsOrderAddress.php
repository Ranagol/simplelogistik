<?php

namespace App\Models;

use App\Models\TmsOrder;
use App\Models\TmsCountry;
use App\Models\TmsPartner;
use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsOrderAddress extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_order_addresses";

    //*************************APPENDING************************** */

    /**
     * APPENDING (attaching a new column to the model, that is originally not in the model's table)
     * Here we want to add country_name to the Address model.
     * Under the country_name key in the response, we will get the country_name of the given address.
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

    //*************************RELATIONSHIPS************************** */

    public function order(): BelongsTo
    {
        return $this->belongsTo(TmsOrder::class, 'order_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(TmsCustomer::class, 'customer_id');
    }

    public function forwarder(): BelongsTo
    {
        return $this->belongsTo(TmsForwarder::class, 'forwarder_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(TmsCountry::class, 'country_id');
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(TmsPartner::class, 'partner_id');
    }

    /**
     * Here we set the address type db column possible options. This array will be used during
     * seeding too. So, when you want to add a new address type, this is the place to do it.
     */
    const ADDRESS_TYPES = [
        1 => 'Headquarter',
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
                // dd($value);
                return array_flip(self::ADDRESS_TYPES)[$value] ?? 'Missing data TmsAddress model.';
            }

        );
    }
}