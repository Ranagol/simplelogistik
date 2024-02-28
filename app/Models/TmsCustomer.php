<?php

namespace App\Models;

use App\Models\TmsGear;
use App\Models\TmsOrder;
use App\Models\TmsAddress;
use App\Models\TmsContact;
use App\Models\TmsInvoice;
use App\Models\TmsVehicle;
use App\Models\TmsOrderAddress;
use App\Models\TmsOrderHistory;
use App\Models\TmsPaymentMethod;
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

    public const CUSTOMER_TYPES = [
        1 => 'Bussiness customer',
        2 => 'Private customer',
    ];

    public const INVOICE_DISPATCHES = [
        1 => 'Direct',
        2 => 'Collected invoicing',
    ];

    public const INVOICE_SHIPPING_METHODS = [
        1 => 'Email',
    ];

    /**
     * This is the list of legal entity types used in customers, forwarders and partners. The source
     * is here.
     */
    public const LEGAL_ENTITY_TYPES = [
        1 => 'GmbH',
        2 => 'AG',
        3 => 'KG',
        4 => 'GmbH & Co. KG',
        5 => 'GBR',
    ];

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

    public $searchable = [
        'company_name',
        'first_name',
        'last_name',
        'email',
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
     */
    public function headquarter()
    {
        return $this->hasOne(TmsAddress::class, 'customer_id')
                    // ->select('id', 'customer_id', 'street', 'house_number', 'zip_code', 'city')
                    ->where('is_headquarter', true);
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

    public function invoiceHistories(): HasMany
    {
        return $this->hasMany(TmsInvoiceHistory::class, 'customer_id');
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

    public function paymentMethods(): BelongsToMany
    {
        return $this->belongsToMany(
            TmsPaymentMethod::class, 
            'customer_payment_method', 
            'customer_id', 
            'payment_method_id'
        );
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


    
}
