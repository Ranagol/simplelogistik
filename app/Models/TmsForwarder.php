<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmsForwarder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_forwarders";
}