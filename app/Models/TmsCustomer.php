<?php

namespace App\Models;

use App\Models\TmsOrder;
use App\Models\TmsAddress;
use App\Models\TmsContact;
use App\Models\TmsInvoice;
use App\Models\TmsVehicle;
use App\Models\TmsGear;
use App\Models\TmsOrderAddress;
use App\Models\TmsOrderHistory;
use App\Models\TmsForwardingContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        
        //boolean casting
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
        
        //json data casting
        'comments' => 'array',
        'payment_method_options_to_offer' => 'array',
    ];

    /**
     * APPENDING (attaching a new column to the model, that is originally not in the model's table)
     * Here we want to add country_name to the Address model.
     * Under the country_name key in the response, we will get the country_name of the given address.
     *
     * @var array
     */
    protected $appends = [
        'forwarder',
    ];

    public function getForwarderAttribute()
    {
        //$this->forwarder_id is the forwarder_id of the current Address model.
        $forwarder = TmsForwarder::select('id', 'company_name', 'name')->find($this->forwarder_id);
        
        if($forwarder && $forwarder->company_name){
            //If the forwarder has a company_name, let the company_name be the customer_name.
            $forwarderName = $forwarder ? $forwarder->company_name : 'TmsAddress appends error.';
        }else{
            //If the forwarder has no company_name, let the first_name and last_name be the customer_name.
            $forwarderName = $forwarder ? $forwarder->name : 'TmsAddress appends error.';
        }

        //We need only the id and the name of the forwarder. So we format the forwarder object.
        $formattedForwarder = [
            'id' => $forwarder ? $forwarder->id : null,
            'name' => $forwarder ? $forwarderName : null
        ];

        return $formattedForwarder;
    }

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
     * I use hasMany relationship, because it may happen that the customer has both headquarter and
     * billing address.
     */
    public function headquarter()
    {
        return $this->hasMany(TmsAddress::class, 'customer_id')
                    ->select('id', 'customer_id', 'street', 'house_number', 'zip_code', 'city')
                    ->where('is_headquarter', true)
                    ->orWhere('is_billing', true)
                    ;
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

    public function gears(): BelongsToMany
    {
        /**
         * gear_customer is a pivot table between gear and customer
         * customer_id and gear_id are the custom column names in the gear_customer pivot table
         */
        return $this->belongsToMany(TmsGear::class, 'gear_customer', 'customer_id', 'gear_id');
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
        return $query->where('company_name', 'like', "%{$searchTerm}%")
            ->orWhere('email', 'like', "%{$searchTerm}%")
            ->orWhere('first_name', 'like', "%{$searchTerm}%")
            ->orWhere('last_name', 'like', "%{$searchTerm}%")
            ;
    }

    //*************MUTATORS AND ACCESSORS*************************************** */

    /**
     * Here we set the customer type db column possible options. This array will be used during
     * seeding too. So, when you want to add a new customer type, this is the place to do it.
     */
    const CUSTOMER_TYPES = [
        1 => 'Bussiness customer',
        2 => 'Private customer',
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
        5 => 'Invoice'
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
