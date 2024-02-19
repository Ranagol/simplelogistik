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
use App\Models\TmsPaymentMethod;
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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TmsOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_orders";

    /**
     * This is the format of the order numbers in the old app: 465244. We will use this number
     * to number the orders in the new app. The first order will have the number 465245.
     *
     * @var integer
     */
    public const ORDER_NUMBER_START_VALUE = 465244;

    public const TYPES_OF_TRANSPORT = [
        1 => 'General cargo',
        2 => 'LTL/FTL',
        3 => 'Direct transport',
        4 => 'Parcell up to 31.5 kg',
        5 => 'Special order',
        6 => 'Regel tour'
    ];

    /**
     * This is the source, the origin of the order.
     */
    public const ORIGINS = [
        1 => 'pamyra',
        2 => 'native_sales',
        3 => 'native_google-ads',
        4 => 'shipping_calc.'
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

    /**
     * Returns all order histories.
     *
     * @return HasMany
     */
    public function orderHistories(): HasMany
    {
        return $this->hasMany(TmsOrderHistory::class, 'order_id');
    }

    /**
     * Returns the latest order history record. Only one. This is needed in order index page.
     * And not in order edit page.
     *
     * @return HasOne
     */
    public function orderHistoryLatest(): HasOne
    {
        return $this
            ->hasOne(TmsOrderHistory::class, 'order_id')
            ->with('user', function($query){
                $query->select('id', 'name');
            })
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

    /**
     * Returns only the billing address.
     *
     * @return HasOne
     */
    public function billingAddress(): BelongsTo
    {
        return $this->belongsTo(TmsAddress::class, 'billing_address_id')
            ->where('is_billing', true);
    }

    public function forwarder(): BelongsTo
    {
        return $this->belongsTo(TmsForwarder::class, 'forwarder_id');
    }

    public function paymentMethods(): BelongsToMany
    {
        return $this->belongsToMany(
            TmsPaymentMethod::class, 
            'order_payment_method', 
            'order_id', 
            'payment_method_id'
        );
    }

    public function orderStatus(): BelongsTo
    {
        return $this->belongsTo(TmsOrderStatus::class, 'order_status_id');
    }

    public function orderAttributes(): BelongsToMany
    {
        return $this->belongsToMany(
            TmsOrderAttribute::class, 
            'order_order_attribute', 
            'order_id', 
            'order_attribute_id'
        );
    }


}
