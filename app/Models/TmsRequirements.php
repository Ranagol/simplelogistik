<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TmsCustomerReq;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsRequirements extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_requirements";

    public function requirementsForCustomer(): BelongsTo
    {
        return $this->belongsTo(TmsCustomerReq::class);
    }

    public function requirementsForVehicle(): BelongsTo
    {
        return $this->belongsTo(TmsVehicleReq::class);
    }
}
