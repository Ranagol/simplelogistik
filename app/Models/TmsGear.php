<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TmsNeededGear;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TmsGear extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_gears";

}
