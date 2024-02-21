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
        1 => [
            'name' => 'pamyra-stuckgut-partner',
            'description' => 'If the type_of_transport is Stuckgut, then the partner should be automatically Emons Villingen during creating Pamyra orders from Pamyra json files',
            'condition_field' => 'calculationModelName',
            'condition' => 'contains Stückgut',
            'condition_operator' => 'equal',
            'consequence' => 'type_of_transport',
        ],
    ];
}
