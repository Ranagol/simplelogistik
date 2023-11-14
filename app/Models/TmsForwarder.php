<?php

namespace App\Models;

use App\Models\TmsAddress;
use App\Models\TmsContact;
use App\Models\TmsVehicle;
use App\Models\TmsOfferPrice;
use App\Models\TmsCargoHistory;
use App\Models\TmsTransportLicense;
use App\Models\TmsForwardingContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsForwarder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_forwarders";

    public function addresses(): HasMany
    {
        return $this->hasMany(TmsAddress::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(TmsContact::class);
    }

    public function forwardingContracts(): HasMany
    {
        return $this->hasMany(TmsForwardingContract::class);
    }

    public function cargoHistories(): HasMany
    {
        return $this->hasMany(TmsCargoHistory::class);
    }

    public function offerPrices(): HasMany
    {
        return $this->hasMany(TmsOfferPrice::class);
    }

    public function transportLicenses(): HasMany
    {
        return $this->hasMany(TmsTransportLicense::class);
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(TmsVehicle::class);
    }
}
