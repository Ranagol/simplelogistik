<?php

namespace App\Models;

use App\Models\TmsCustomer;
use App\Models\TmsRequirement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TmsCustomerReq extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_customer_reqs";
    public function requirement(): BelongsTo
    {
        return $this->belongsTo(TmsRequirement::class);
    }

    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(TmsCustomer::class, 'requirements_for_customers');
    }
}
