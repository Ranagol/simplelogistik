<?php

namespace App\Models;

use App\Models\TmsParcel;
use App\Models\TmsAddress;
use App\Models\TmsContact;
use App\Models\TmsInvoice;
use App\Models\TmsPartner;
use App\Models\TmsCustomer;
use App\Models\TmsOfferPrice;
use App\Models\TmsNativeOrder;
use App\Models\TmsPamyraOrder;
use App\Models\TmsOrderAddress;
use App\Models\TmsOrderHistory;
use App\Models\TmsOrderAttribute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\TmsForwardingContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        1 => 'General cargo',
        2 => 'LTL/FTL',
        3 => 'Direct transport',
        4 => 'Parcell up to 31.5 kg',
        5 => 'Special order'
    ];

    /**
     * This is the source, the origin of the order.
     */
    const ORIGINS = [
        1 => 'Pamyra',
        2 => 'Sales',
        3 => 'Google Ads',
        4 => 'Shipping calc.'
    ];

    //*************RELATIONSHIPS*************************************** */    

    public function customer(): BelongsTo
    {
        return $this->belongsTo(TmsCustomer::class);
    }
    
    public function contact(): BelongsTo
    {
        return $this->belongsTo(TmsContact::class, 'contact_id');
    }

    public function orderHistories(): HasMany
    {
        return $this->hasMany(TmsOrderHistory::class, 'order_id');
    }

    /**
     * Returns the latest order history record. Only one.
     *
     * @return HasOne
     */
    public function orderHistoryLatest(): HasOne
    {
        return $this->hasOne(TmsOrderHistory::class, 'order_id')
            ->latest();
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(TmsInvoice::class, 'order_id');
    }

    public function offerPrices(): HasMany
    {
        return $this->hasMany(TmsOfferPrice::class, 'order_id');
    }

    public function parcels(): HasMany
    {
        return $this->hasMany(TmsParcel::class, 'tms_order_id');
    }

    public function orderAttributes(): HasMany
    {
        return $this->hasMany(TmsOrderAttribute::class, 'tms_order_id');
    }

    public function forwardingContract(): HasOne
    {
        return $this->hasOne(TmsForwardingContract::class, 'order_id');
    }
    

    /**
     * Currently, every TmsOrder has a suborder, either a PamyraOrder or a NativeOrder.
     *
     * @return HasOne
     */
    public function pamyraOrder(): HasOne
    {
        return $this->hasOne(TmsPamyraOrder::class, 'order_id');
    }

    /**
     * Currently, every TmsOrder has a suborder, either a PamyraOrder or a NativeOrder.
     *
     * @return HasOne
     */
    public function nativeOrder(): HasOne
    {
        return $this->hasOne(TmsNativeOrder::class, 'order_id');
    }

    /**
     * An order could belong to a partner. This is optional, does not happen always. Example:
     * an order that we received from Pamyra belongs (amongst other belongings) to Pamyra partner.
     *
     * @return BelongsTo
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(TmsPartner::class);
    }

    /**
     * Returns ALL order addresses, pickup and delivery together.
     *
     * @return HasMany
     */
    public function orderAddresses(): HasMany
    {
        return $this->hasMany(TmsOrderAddress::class, 'order_id');
    }

    /**
     * Returns only the pickup addresses.
     *
     * @return HasMany
     */
    public function pickupAddresses(): HasMany
    {
        return $this->hasMany(TmsOrderAddress::class, 'order_id')
            ->where('address_type', 3);
    }

    /**
     * Returns only the delivery addresses.
     *
     * @return HasMany
     */
    public function deliveryAddresses(): HasMany
    {
        return $this->hasMany(TmsOrderAddress::class, 'order_id')
            ->where('address_type', 4);
    }

    public function forwarder(): BelongsTo
    {
        return $this->belongsTo(TmsForwarder::class, 'forwarder_id');
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
        return $query->where('type_of_transport', 'like', "%{$searchTerm}%")
            ->orWhere('customer_reference', 'like', "%{$searchTerm}%")
            ->orWhere('status', 'like', "%{$searchTerm}%")
            ;
    }

    //*************MUTATORS AND ACCESSORS*************************************** */
    
    /**
     * These are the possible order statuses.
     * Waring: if we display the keys too (like 1 => 'Order created'), then we Laravel return an
     * object. If we display only the values (like 'Order created'), then Laravel returns an array.
     */
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

    /**
     * This here is a Laravel accessor, for getting the status name.
     * https://laravel.com/docs/10.x/eloquent-mutators#defining-an-accessor
     *
     * @return Attribute
     */
    protected function status(): Attribute
    {
        return Attribute::make(

            /**
             * Accessor.
             * Gets 1 from db, transforms it to 'Order created'.
             */
            get: function (string $value) {
                return self::STATUSES[$value] ?? 'Missing data TmsOrder.';
            },

            /**
             * Mutator.
             * Gets 'Order created' from the form, transforms it to 1.
             */
            set: function (string $value) {
                return array_flip(self::STATUSES)[$value] ?? 'Missing data TmsOrder.';
            }
        );
    }

    /**
     * This mutator is used for the payment_method column in the tms_orders table. Do not mix it with
     * the similar mutator from TmsCustomer model.
     * If you want to change or add a new payment method, do it in the TmsCustomer model. The payment
     * methods are defined there.
     *
     * @return Attribute
     */
    protected function paymentMethod(): Attribute
    {
        return Attribute::make(
            //gets from db, transforms it. 1 will become 'Paypal'.
            get: fn (string $value) => TmsCustomer::PAYMENT_METHODS[$value] ?? 'Missing data xxx.',
            //gets from request, transforms it. 'Paypal' will become 1.
            set: fn (string $value) => array_flip(TmsCustomer::PAYMENT_METHODS)[$value] ?? 'Missing data xxx.',
        );
    }

}
