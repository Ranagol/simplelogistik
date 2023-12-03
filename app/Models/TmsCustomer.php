<?php

namespace App\Models;

use App\Models\TmsAddress;
use App\Models\TmsContact;
use App\Models\TmsInvoice;
use App\Models\TmsVehicle;
use App\Models\TmsCargoOrder;
use App\Models\TmsCargoHistory;
use App\Models\TmsForwardingContract;
use Illuminate\Database\Eloquent\Model;
use App\Models\TmsCustomerReq;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class TmsCustomer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $table = "tms_customers";

    public function addresses(): HasMany
    {
        return $this->hasMany(TmsAddress::class, 'customer_id');
    }

    public function cargoOrders(): HasMany
    {
        return $this->hasMany(TmsCargoOrder::class, 'customer_id');
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
    
    public function cargoHistories(): HasMany
    {
        return $this->hasMany(TmsCargoHistory::class, 'customer_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(TmsInvoice::class, 'customer_id');
    }

    public function customerReqs(): BelongsToMany
    {
        return $this->belongsToMany(TmsCustomerReq::class, 'requirements_for_customers');
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
        return $query->where('company_name', 'like', "%{$searchTerm}%")
            ->orWhere('email', 'like', "%{$searchTerm}%");
    }

    
                
}
