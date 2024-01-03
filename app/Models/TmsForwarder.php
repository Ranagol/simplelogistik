<?php

namespace App\Models;

use App\Models\TmsAddress;
use App\Models\TmsContact;
use App\Models\TmsVehicle;
use App\Models\TmsOfferPrice;
use App\Models\TmsOrderHistory;
use App\Models\TmsTransportLicense;
use App\Models\TmsForwardingContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TmsForwarder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_forwarders";

    public function addresses(): HasMany
    {
        return $this->hasMany(TmsAddress::class, 'forwarder_id');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(TmsContact::class, 'forwarder_id');
    }

    public function forwardingContracts(): HasMany
    {
        return $this->hasMany(TmsForwardingContract::class, 'forwarder_id');
    }
    
    public function orderHistories(): HasMany
    {
        return $this->hasMany(TmsOrderHistory::class, 'forwarder_id');
    }

    public function offerPrices(): HasMany
    {
        return $this->hasMany(TmsOfferPrice::class, 'forwarder_id');
    }

    public function transportLicenses(): HasMany
    {
        return $this->hasMany(TmsTransportLicense::class, 'forwarder_id');
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(TmsVehicle::class, 'forwarder_id');
    }

    public function forwarderReqs(): BelongsToMany
    {
        //forwarder_forwarder_req_pivot is the pivot table name between forwarders and forwarder_reqs
        return $this->belongsToMany(TmsForwarderReq::class, 'forwarder_forwarder_req_pivot');
    }

    //*************MUTATORS AND ACCESSORS*************************************** */

    /**
     * Here we set the forwarder type db column possible options. This array will be used during
     * seeding too. So, when you want to add a new forwarder type, this is the place to do it.
     */
    const FORWARDER_TYPES = [
        1 => 'GmbH',
        2 => 'AG',
    ];

    protected function forwarderType(): Attribute//this is called forwarderType because the db column is forwarder_type
    {
        return Attribute::make(

            /**
             * Accessor
             * gets from db, transforms it. 1 will become 'GmbH'.
             * directly looks up the forwarder type in the FORWARDER_TYPES constant using the provided
             * value. If the value is not found in the constant, it defaults to 'Missing data.'.
             */
            get: fn (string $value) => self::FORWARDER_TYPES[$value] ?? 'Missing data TmsForwarder model.',

            /**
             * Mutator
             * gets from request, transforms it. 'GmbH' will become 1.
             *
             * To implement the setter using the FORWARDER_TYPES constant, you need to flip the array
             * keys and values because you're mapping from the string representation back to the
             * integer value.
             * The set method uses array_flip to swap the keys and values of the FORWARDER_TYPES
             * constant, then looks up the integer value corresponding to the provided forwarder type
             * string. If the string is not found in the flipped array, it defaults to 'Missing data.'.
             */
            set: fn (string $value) => array_flip(self::FORWARDER_TYPES)[$value] ?? 'Missing data TmsForwarder model.',
        );
    }

}
