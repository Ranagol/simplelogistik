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
        return $this->hasMany(TmsAddress::class, 'forwarder_id');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(TmsContact::class, 'forwarder_id');
    }

    public function forwardingContracts(): HasMany
    {
        return $this->hasMany(TmsForwardingContract::class, 'forwarder_id');
    }
    
    public function cargoHistories(): HasMany
    {
        return $this->hasMany(TmsCargoHistory::class, 'forwarder_id');
    }

    public function offerPrices(): HasMany
    {
        return $this->hasMany(TmsOfferPrice::class, 'forwarder_id');
    }

    public function transportLicenses(): HasMany
    {
        return $this->hasMany(TmsTransportLicense::class, 'forwarder_id');
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(TmsVehicle::class, 'forwarder_id');
    }
}
