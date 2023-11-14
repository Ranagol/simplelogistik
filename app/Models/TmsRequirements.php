<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TmsRequirementsForCustomer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsNeedsOptions extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_requirements";

    public function needsOptionsToCustomer(): BelongsTo
    {
        return $this->belongsTo(TmsRequirementsForCustomer::class);
    }

    public function needsOptionsToVehicle(): BelongsTo
    {
        return $this->belongsTo(TmsRequirementsForVehicle::class);
    }
}
