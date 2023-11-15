<?php

namespace App\Models;

use App\Models\TmsAddress;
use App\Models\TmsContact;
use App\Models\TmsInvoice;
use App\Models\TmsCustomer;
use App\Models\TmsCargoHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TmsCargoOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_cargo_orders";

    public function cargoOrder(): BelongsTo
    {
        return $this->belongsTo(TmsCustomer::class);
    }

    public function contact(): HasOne
    {
        return $this->hasOne(TmsContact::class);
    }

    public function startAddress(): HasOne
    {
        return $this->hasOne(TmsAddress::class, 'start_address_id');
    }

    public function targetAddress(): HasOne
    {
        return $this->hasOne(TmsAddress::class, 'target_address_id');
    }

    public function cargoHistory(): HasOne
    {
        return $this->hasOne(TmsCargoHistory::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(TmsInvoice::class);
    }

    public function offerPrices(): HasMany
    {
        return $this->hasMany(TmsOfferPrice::class);
    }
}
