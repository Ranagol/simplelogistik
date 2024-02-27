<?php

namespace App\Models;

use App\Models\TmsOrder;
use App\Models\TmsCountry;
use App\Models\TmsPartner;
use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Address in general belong to a customer. Every customer has his own usual address where/from he
 * usually sends his packages. When we have a specific order, then we select from these addresses
 * the pickup and delivery address. These two special address will from this moment belong to the
 * given order too. These two address ids will be stored in the orders table. Because they are so
 * important.
 */
class TmsAddress extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_addresses";

    public $searchable = [
        'first_name',
        'last_name',
        'street',
        'zip',
        'city',
    ];

    protected $casts = [
        'is_pickup' => 'boolean',
        'is_delivery' => 'boolean',
        'is_billing' => 'boolean',
        'is_headquarter' => 'boolean',
    ];

    //***********************RELATIONSHIPS********************************** */

    public function customer(): BelongsTo
    {
        return $this->belongsTo(TmsCustomer::class);
    }

    public function forwarder(): BelongsTo
    {
        return $this->belongsTo(TmsForwarder::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(TmsCountry::class, 'country_id');
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(TmsPartner::class);
    }

}
