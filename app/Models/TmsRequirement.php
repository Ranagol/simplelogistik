<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TmsCustomerReq;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TmsRequirement extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_requirements";

    public function customerReqs(): HasMany
    {
        return $this->hasMany(TmsCustomerReq::class, 'requirement_id');
    }

    public function vehicleReqs(): HasMany
    {
        return $this->hasMany(TmsVehicleReq::class, 'requirement_id');
    }
}
