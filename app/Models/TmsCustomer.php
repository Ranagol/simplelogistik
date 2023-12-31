<?php

namespace App\Models;

use App\Models\TmsAddress;
use App\Models\TmsContact;
use App\Models\TmsInvoice;
use App\Models\TmsVehicle;
use App\Models\TmsOrder;
use App\Models\TmsOrderHistory;
use App\Models\TmsForwardingContract;
use Illuminate\Database\Eloquent\Model;
use App\Models\TmsCustomerReq;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class TmsCustomer extends Model
{
    use HasFactory;
    // use SoftDeletes;//I turned off soft delete, because it is confusing during development and testing.

    protected $guarded = ['id'];
    
    protected $table = "tms_customers";

    /**
     * These values are stored as 0 or 1 in the database. But we want to use them as booleans.
     * So we use this casting for this.
     *
     * @var array
     */
    protected $casts = [
        //booleans
        'auto_book_as_private' => 'boolean',
        'dangerous_goods' => 'boolean',
        'bussiness_customer' => 'boolean',
        'debt_collection' => 'boolean',
        'direct_debit' => 'boolean',
        'manual_collective_invoicing' => 'boolean',
        'only_paypal_sofort_amazon_vorkasse' => 'boolean',
        'private_customer' => 'boolean',
        'invoice_customer' => 'boolean',
        'poor_payment_morale' => 'boolean',
        'can_login' => 'boolean',
        'paypal' => 'boolean',
        'sofort' => 'boolean',
        'amazon' => 'boolean',
        'vorkasse' => 'boolean',
        //json data
        'comments' => 'array',
    ];

    //*************RELATIONSHIPS*************************************** */

    /**
     * Relationship for all addresses. No matter is headquarter or billing, or whatever.
     *
     * @return HasMany
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(TmsAddress::class, 'customer_id');
    }

    /**
     * Relationship for the headquarter address.
     *
     * @return HasOne
     */
    public function headquarter()
    {
        return $this->hasOne(TmsAddress::class, 'customer_id')
                    ->where('address_type', 1);
                    // ->orWhere('address_type', 2)
                    // ->orderBy('address_type', 'asc')
                    // ->take(1);
    }

    /**
     * This is needed for the customers, for the edit and the list view. We have to display (if exist)
     * the headquarter address of the customer. If that does not exist, we have to display the
     * billing address. 
     * To achive this, we have to order the addresses by address_type, and take the first one.
     *
     * @return HasMany
     */
    public function contactAddresses(): HasMany
    {
        return $this->hasMany(TmsAddress::class, 'customer_id')
                    ->orderBy('address_type', 'asc');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(TmsOrder::class, 'customer_id');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(TmsContact::class, 'customer_id');
    }

    public function forwardingContracts(): HasMany
    {
        return $this->hasMany(TmsForwardingContract::class, 'customer_id');
    }

    public function vehicle(): HasOne
    {
        return $this->hasOne(TmsVehicle::class);
    }
    
    public function orderHistories(): HasMany
    {
        return $this->hasMany(TmsOrderHistory::class, 'customer_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(TmsInvoice::class, 'customer_id');
    }

    public function customerReqs(): BelongsToMany
    {
        //customer_customer_req_pivot is the pivot table name between customers and customer_reqs
        return $this->belongsToMany(TmsCustomerReq::class, 'customer_customer_req_pivot');
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
            ->orWhere('email', 'like', "%{$searchTerm}%");
    }

    //*************MUTATORS AND ACCESSORS*************************************** */

    /**
     * Here we set the customer type db column possible options. This array will be used during
     * seeding too. So, when you want to add a new customer type, this is the place to do it.
     */
    const CUSTOMER_TYPES = [
        1 => 'Bussiness customer',
        2 => 'Private customer',
        3 => 'Forwarder',
    ];
    
    protected function customerType(): Attribute
    {
        return Attribute::make(

            /**
             * Accessor
             * gets from db, transforms it. 1 will become 'Bussiness customer'.
             * directly looks up the customer type in the CUSTOMER_TYPES constant using the provided 
             * value. If the value is not found in the constant, it defaults to 'Missing data xxx.'.
             */
            get: fn (string $value) => self::CUSTOMER_TYPES[$value] ?? 'Missing data xxx.',

            /**
             * Mutator
             * gets from request, transforms it. 'Bussiness customer' will become 1.
             * 
             * To implement the setter using the CUSTOMER_TYPES constant, you need to flip the array 
             * keys and values because you're mapping from the string representation back to the 
             * integer value.
             * he set method uses array_flip to swap the keys and values of the CUSTOMER_TYPES 
             * constant, then looks up the integer value corresponding to the provided customer type 
             * string. If the string is not found in the flipped array, it defaults to 'Missing data xxx.'.
             */
            set: fn (string $value) => array_flip(self::CUSTOMER_TYPES)[$value] ?? 'Missing data xxx.',
        );
    }

    const INVOICE_DISPATCHES = [
        1 => 'Direct',
        2 => 'Collected invoicing',
    ];

    protected function invoiceDispatch(): Attribute
    {
        // dd('xxxx');
        return Attribute::make(
            //gets from db, transforms it. 1 will become 'Bussiness customer'.
            get: fn (string $value) => self::INVOICE_DISPATCHES[$value] ?? 'Missing data xxx.',
            //gets from request, transforms it. 'Bussiness customer' will become 1.
            set: fn (string $value) => array_flip(self::INVOICE_DISPATCHES)[$value] ?? 'Missing data xxx.',
        );
    }

    const INVOICE_SHIPPING_METHODS = [
        1 => 'Email',
        2 => 'Post',
    ];

    protected function invoiceShippingMethod(): Attribute
    {
        return Attribute::make(
            //gets from db, transforms it. 1 will become 'Bussiness customer'.
            get: fn (string $value) => self::INVOICE_SHIPPING_METHODS[$value] ?? 'Missing data xxx.',
            //gets from request, transforms it. 'Bussiness customer' will become 1.
            set: fn (string $value) => array_flip(self::INVOICE_SHIPPING_METHODS)[$value] ?? 'Missing data xxx.',
        );
    }

    const PAYMENT_METHODS = [
        1 => 'PayPal',
        2 => 'Sofort',
        3 => 'Amazon',
        4 => 'Vorkasse',
    ];

    protected function paymentMethod(): Attribute
    {
        return Attribute::make(
            //gets from db, transforms it. 1 will become 'Bussiness customer'.
            get: fn (string $value) => self::PAYMENT_METHODS[$value] ?? 'Missing data xxx.',
            //gets from request, transforms it. 'Bussiness customer' will become 1.
            set: fn (string $value) => array_flip(self::PAYMENT_METHODS)[$value] ?? 'Missing data xxx.',
        );
    }
    

}
