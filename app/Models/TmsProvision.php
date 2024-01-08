<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Example: the provision for Pamyra is 1.5% of the total price. This example 1.5% is the provision.
 */
class TmsProvision extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_provisions";
}
