<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmsRequirementsForForwarder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_requirements_for_forwarders";
}
