<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

// TODO TmsRequirementsForVehicle
class TmsRequirementsForVehicle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_requirements_for_vehicles";

    public function requirements(): HasMany
    {
        return $this->hasMany(TmsRequirements::class);
    }

    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(TmsVehicle::class, 'requirements_for_vehicles');
    }
}
