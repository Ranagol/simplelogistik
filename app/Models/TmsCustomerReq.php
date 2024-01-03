<?php

namespace App\Models;

use App\Models\TmsCustomer;
use App\Models\TmsRequirement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * These are the customer requirements.
 */
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
        //customer_customer_req_pivot is the pivot table name between customers and customer_reqs
        return $this->belongsToMany(TmsCustomer::class, 'customer_customer_req_pivot');
    }
}
