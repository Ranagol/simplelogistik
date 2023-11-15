<?php

namespace App\Models;

use App\Models\TmsForwarder;
use App\Models\TmsForwardingContract;
use Illuminate\Database\Eloquent\Model;
use App\Models\TmsRequirementsForVehicle;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TmsVehicle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_vehicles";

    public function forwardingContract(): BelongsTo
    {
        return $this->belongsTo(TmsForwardingContract::class);
    }

    public function forwarder(): BelongsTo
    {
        return $this->belongsTo(TmsForwarder::class);
    }

    public function requirementsForVehicles(): BelongsToMany
    {
        return $this->belongsToMany(TmsRequirementsForVehicle::class, 'requirements_for_vehicles');
    }
}
