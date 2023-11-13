<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmsCargoorder extends Model
{
    use HasFactory;

    /**
     * id is protected from mass assigment, all else can be freely changed.
     */
    protected $guarded = ['id'];

}
