<?php

namespace App\Models;

use App\Models\TmsNeedsOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsNeedsOptionsToCustomer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_needs_options_to_customers";

    public function needsOptions(): HasMany
    {
        return $this->hasMany(TmsNeedsOptions::class);
    }

    public function customers(): HasMany
    {
        return $this->hasMany(TmsCustomer::class);
    }
}
