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

    const PAYMENT_METHODS = [
        1 => 'Credit Card', 
        2 => 'Paypal', 
        3 => 'Bank Transfer',
        4 => 'Amazon',
        5 => 'Sofort',
        6 => 'Vorkasse'
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
     * Currently, every TmsOrder has a suborder, either a PamyraOrder or a NativeOrder. It is either
     * a PamyraOrder or a NativeOrder, never both. That is why we use this funny method here.
     * It will return the suborder, either a PamyraOrder or a NativeOrder. That is OK, because
     * both tables have exactly the same structure.
     *
     */
    public function subOrder()
    {
        if ($this->nativeOrder()) {//this if condition is the problem
            return $this->nativeOrder();
        }

        if ($this->pamyraOrder()) {//this if condition is the problem
            return $this->pamyraOrder();
        }

        $users = User::withWhereHas('posts', function ($query) {
            $query->where('featured', true);
        })->get();
    }

    /**
     * See the comment above the subOrder() method.
     *
     * @return HasOne
     */
    public function pamyraOrder(): HasOne
    {
        return $this->hasOne(TmsPamyraOrder::class, 'order_id');
    }

    /**
     * See the comment above the subOrder() method.
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

    public function orderAddresses(): HasMany
    {
        return $this->hasMany(TmsOrderAddress::class, 'order_id');
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
        3 =>'Forwarder found',
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

}
