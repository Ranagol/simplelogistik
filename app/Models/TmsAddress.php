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
        'country',
        'customer',
        'forwarder',
        'partner'
    ];
    
    /**
     * Attaches a the belonging country object to the Address model.
     *
     * @return object
     */
    public function getCountryAttribute()
    {
        //$this->country_id is the country_id of the current Address model.
        return TmsCountry::select('id', 'country_name')->find($this->country_id);
    }

    public function getCustomerAttribute()
    {
        //$this->customer_id is the customer_id of the current Address model.
        $customer = TmsCustomer::select('id', 'company_name', 'first_name', 'last_name')->find($this->customer_id);
        if($customer && !$customer->company_name){//Attempt to read property "company_name" on null
            //If the customer has a company_name, let the company_name be the customer_name.
            $customerName = $customer ? $customer->company_name : 'TmsAddress appends error.';
        }else{
            //If the customer has no company_name, let the first_name and last_name be the customer_name.
            $customerName = $customer ? $customer->first_name.' '.$customer->last_name : 'TmsAddress appends error.';
        }

        //We need only the id and the name of the customer. So we format the customer object.
        $formattedCustomer = [
            'id' => $customer ? $customer->id : null,
            'name' => $customer ? $customerName : null
        ];

        return $formattedCustomer;
    }

    public function getForwarderAttribute()
    {
        //$this->forwarder_id is the forwarder_id of the current Address model.
        $forwarder = TmsForwarder::select('id', 'company_name', 'name')->find($this->forwarder_id);
        
        if($forwarder && !$forwarder->company_name){
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

    public function getPartnerAttribute()
    {
        //$this->partner_id is the partner_id of the current Address model.
        $partner = TmsPartner::select('id', 'company_name', 'name')->find($this->partner_id);
        
        if($partner && !$partner->company_name){
            //If the partner has a company_name, let the company_name be the partner name.
            $partnerName = $partner ? $partner->company_name : 'TmsAddress appends error.';
        }else{
            //If the partner has no company_name, let the first_name and last_name be the partner name.
            $partnerName = $partner ? $partner->name : 'TmsAddress appends error.';
        }

        //We need only the id and the name of the partner. So we format the partner object.
        $formattedPartner = [
            'id' => $partner ? $partner->id : null,
            'name' => $partner ? $partnerName : null
        ];

        return $formattedPartner;
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
