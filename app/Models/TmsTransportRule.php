<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmsTransportRule extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'tms_transport_rules';

    const TRANSPORT_RULES = [
        
    ];
}
