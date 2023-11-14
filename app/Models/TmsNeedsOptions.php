<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TmsNeedsOptionsToCustomer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsNeedsOptions extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_needs_options";

    public function needsOptionsToCustomer(): BelongsTo
    {
        return $this->belongsTo(TmsNeedsOptionsToCustomer::class);
    }

    public function needsOptionsToVehicle(): BelongsTo
    {
        return $this->belongsTo(TmsNeedsOptionsToVehicle::class);
    }
}
