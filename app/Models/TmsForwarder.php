<?php

namespace App\Models;

use App\Models\TmsAddress;
use App\Models\TmsContact;
use App\Models\TmsVehicle;
use App\Models\TmsOfferPrice;
use App\Models\TmsOrderAddress;
use App\Models\TmsOrderHistory;
use App\Models\TmsTransportLicense;
use App\Models\TmsForwardingContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class TmsForwarder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = "tms_forwarders";

    public $searchable = [
        'company_name',
        'name',
        'email'
    ];

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

    public function invoiceHistories(): HasMany
    {
        return $this->hasMany(TmsInvoiceHistory::class, 'forwarder_id');
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

    public function gears(): BelongsToMany
    {
        /**
         * gear_forwarder is a pivot table between gear and forwarder
         * forwarder_id and gear_id are the custom column names in the gear_forwarder pivot table
         */
        return $this->belongsToMany(TmsGear::class, 'gear_forwarder', 'forwarder_id', 'gear_id');
    }

    public function orderAddresses(): HasMany
    {
        return $this->hasMany(TmsOrderAddress::class, 'order_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(TmsOrder::class, 'forwarder_id');
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
        return $query->where('company_name', 'like', "%{$searchTerm}%")
            ->orWhere('name', 'like', "%{$searchTerm}%")
            ->orWhere('email', 'like', "%{$searchTerm}%")
            ->orWhere('tax_number', 'like', "%{$searchTerm}%")
            ->orWhere('comments', 'like', "%{$searchTerm}%")
            ;
    }

    //*************MUTATORS AND ACCESSORS*************************************** */

    /**
     * Here we set the forwarder type db column possible options. This array will be used during
     * seeding too. So, when you want to add a new forwarder type, this is the place to do it.
     */
    public const FORWARDER_TYPES = [];
}
