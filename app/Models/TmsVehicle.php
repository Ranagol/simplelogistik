<?php

namespace App\Models;

use App\Models\TmsForwarder;
use App\Models\TmsForwardingContract;
use Illuminate\Database\Eloquent\Model;
use App\Models\TmsVehicleReq;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TmsVehicle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_vehicles";
    
    public function forwardingContracts(): HasMany
    {
        return $this->hasMany(TmsForwardingContract::class, 'vehicle_id');
    }

    public function forwarder(): BelongsTo
    {
        return $this->belongsTo(TmsForwarder::class);
    }

    public function vehicleReqs(): BelongsToMany
    {
        return $this->belongsToMany(TmsVehicleReq::class, 'requirements_for_vehicles');
    }
}
