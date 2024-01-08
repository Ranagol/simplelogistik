<?php

namespace App\Models;

use App\Models\TmsParcel;
use App\Models\TmsAddress;
use App\Models\TmsContact;
use App\Models\TmsInvoice;
use App\Models\TmsCustomer;
use App\Models\TmsOrderHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TmsOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_orders";

    const TYPES_OF_TRANSPORT = [
        'General cargo',
        'LTL/FTL',
        'Direct transport',
        'Parcell up to 31.5 kg',
        'Special order'
    ];

    const ORIGINS = [
        'Pamyra',
        'Sales',
        'Google Ads',
        'Shipping calc.'
    ];

    const PAYMENT_METHODS = [
        'Credit Card', 
        'Paypal', 
        'Bank Transfer',
        'Amazon',
        'Sofort',
        'Vorkasse'
    ];

    const STATUSES = [
        1 => 'Order created',
        2 => 'Waiting for forwarder',
        3 => 'Forwarder found',
        4 => 'Picked up',
        5 => 'Delivered',
        6 => 'Canceled',
        7 => 'Invoice sent to customer',
        8 => 'Invoice paid',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(TmsCustomer::class);
    }
    
    public function contact(): BelongsTo
    {
        return $this->belongsTo(TmsContact::class, 'contact_id');
    }

    public function pickupAddress(): BelongsTo
    {
        return $this->belongsTo(TmsAddress::class, 'pickup_address_id');
    }

    public function deliveryAddress(): BelongsTo
    {
        return $this->belongsTo(TmsAddress::class, 'delivery_address_id');
    }

    public function cargoHistory(): HasMany
    {
        return $this->hasMany(TmsOrderHistory::class, 'cargo_order_id');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(TmsInvoice::class, 'cargo_order_id');
    }

    public function offerPrices(): HasMany
    {
        return $this->hasMany(TmsOfferPrice::class, 'cargo_order_id');
    }

    public function parcels(): HasMany
    {
        return $this->hasMany(TmsParcel::class, 'tms_cargo_order_id');
    }

    public function orderAttributes(): HasMany
    {
        return $this->hasMany(TmsOrderAttribute::class, 'tms_cargo_order_id');
    }

    public function forwardingContract(): HasOne
    {
        return $this->hasOne(TmsForwardingContract::class, 'order_id');
    }



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
        return $query->where('type_of_transport', 'like', "%{$searchTerm}%")
            ->orWhere('p_order_number', 'like', "%{$searchTerm}%")
            ;
    }
}
