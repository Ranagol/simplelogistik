<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// TODO TmsRequirementsForVehicle
class TmsRequirementsForVehicle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_requirements_for_vehicles";

    public function needsOptions(): HasMany
    {
        return $this->hasMany(TmsNeedsOptions::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(TmsVehicle::class);
    }
}
