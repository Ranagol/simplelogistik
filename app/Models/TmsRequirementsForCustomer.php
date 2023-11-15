<?php

namespace App\Models;

use App\Models\TmsCustomer;
use App\Models\TmsRequirements;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TmsRequirementsForCustomer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_requirements_for_customers";

    public function requirements(): HasMany
    {
        return $this->hasMany(TmsRequirements::class);
    }

    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(TmsCustomer::class, 'requirements_for_customer');
    }
}
