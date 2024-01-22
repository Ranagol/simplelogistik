<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TmsGear extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_gears";

    public function customers(): BelongsToMany
    {
        /**
         * gear_customer is a pivot table between gear and customer
         * customer_id and gear_id are the custom column names in the gear_customer pivot table
         */
        return $this->belongsToMany(TmsCustomer::class, 'gear_customer','customer_id', 'gear_id');
    }

    public function forwarders(): BelongsToMany
    {
        
        /**
         * gear_forwarder is a pivot table between gear and forwarder
         * forwarder_id and gear_id are the custom column names in the gear_forwarder pivot table
         */
        return $this->belongsToMany(TmsForwarder::class, 'gear_forwarder', 'forwarder_id', 'gear_id');
    }

    public function vehicles(): BelongsToMany
    {
        
        /**
         * gear_vehicle is a pivot table between gear and vehicle
         * vehicle_id and gear_id are the custom column names in the gear_vehicle pivot table
         */
        return $this->belongsToMany(TmsVehicle::class, 'gear_vehicle', 'vehicle_id', 'gear_id');
    }

}
