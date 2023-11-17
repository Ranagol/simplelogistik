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

    public function requirementsForVehicle(): BelongsTo
    {
        return $this->belongsTo(TmsVehicleReq::class);
    }
}
