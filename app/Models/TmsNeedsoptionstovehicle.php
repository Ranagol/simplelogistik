<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmsNeedsOptionsToVehicle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_needs_options_to_vehicles";
}
