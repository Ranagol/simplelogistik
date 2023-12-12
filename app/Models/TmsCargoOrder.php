<?php

namespace App\Models;

use App\Models\TmsParcel;
use App\Models\TmsAddress;
use App\Models\TmsContact;
use App\Models\TmsInvoice;
use App\Models\TmsCustomer;
use App\Models\TmsCargoHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TmsCargoOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_cargo_orders";

    public function customer(): BelongsTo
    {
        return $this->belongsTo(TmsCustomer::class);
    }
    
    public function contact(): BelongsTo
    {
        return $this->belongsTo(TmsContact::class, 'contact_id');
    }

    public function startAddress(): BelongsTo
    {
        return $this->belongsTo(TmsAddress::class, 'start_address_id');
    }

    public function targetAddress(): BelongsTo
    {
        return $this->belongsTo(TmsAddress::class, 'target_address_id');
    }

    public function cargoHistory(): HasOne
    {
        return $this->hasOne(TmsCargoHistory::class, 'cargo_order_id');
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
        return $query->where('description', 'like', "%{$searchTerm}%")
            ->orWhere('internal_oid', 'like', "%{$searchTerm}%");
    }
}
