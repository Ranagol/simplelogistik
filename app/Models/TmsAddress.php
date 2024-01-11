<?php

namespace App\Models;

use App\Models\TmsOrder;
use App\Models\TmsCountry;
use App\Models\TmsPartner;
use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Address in general belong to a customer. Every customer has his own usual address where/from he
 * usually sends his packages. When we have a specific order, then we select from these addresses
 * the pickup and delivery address. These two special address will from this moment belong to the
 * given order too. These two address ids will be stored in the orders table. Because they are so
 * important.
 */
class TmsAddress extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_addresses";

    protected $casts = [
        'is_pickup' => 'boolean',
        'is_delivery' => 'boolean',
        'is_billing' => 'boolean',
        'is_headquarter' => 'boolean',
    ];

    /**
     * APPENDING (attaching a new column to the model, that is originally not in the model's table)
     * Here we want to add country_name to the Address model.
     * Under the country_name key in the response, we will get the country_name of the given address.
     *
     * @var array
     */
    protected $appends = [
        'country_name',
        'customer_name',
        'forwarder_name',
    ];
    
    public function getCountryNameAttribute(): string
    {
        $country = TmsCountry::find($this->country_id);//$this->country_id is the country_id of the current Address model.
        $countryName = $country ? $country->country_name : 'TmsAddress appends error.';
        return $countryName;
    }

    public function getCustomerNameAttribute(): string
    {
        $customer = TmsCustomer::find($this->customer_id);//$this->customer_id is the customer_id of the current Address model.
        if($customer->company_name != null){
            //If the customer has a company_name, let the company_name be the customer_name.
            $customerName = $customer ? $customer->company_name : 'TmsAddress appends error.';
        }else{
            //If the customer has no company_name, let the first_name and last_name be the customer_name.
            $customerName = $customer ? $customer->first_name.' '.$customer->last_name : 'TmsAddress appends error.';
        }
        
        return $customerName;
    }

    public function getForwarderNameAttribute(): string
    {
        $forwarder = TmsForwarder::find($this->forwarder_id);//$this->forwarder_id is the forwarder_id of the current Address model.
        $forwarderName = $forwarder ? $forwarder->company_name : 'TmsAddress appends error.';
        return $forwarderName;
    }


    //***********************RELATIONSHIPS********************************** */

    public function customer(): BelongsTo
    {
        return $this->belongsTo(TmsCustomer::class);
    }

    public function forwarder(): BelongsTo
    {
        return $this->belongsTo(TmsForwarder::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(TmsCountry::class, 'country_id');
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(TmsPartner::class);
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
        return $query->where('first_name', 'like', "%{$searchTerm}%")
            ->orWhere('last_name', 'like', "%{$searchTerm}%")
            ->orWhere('street', 'like', "%{$searchTerm}%")
            ->orWhere('city', 'like', "%{$searchTerm}%")
            ->orWhere('state', 'like', "%{$searchTerm}%")
            ;
    }
}
