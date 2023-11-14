<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmsCargoHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_cargo_histories";
}
