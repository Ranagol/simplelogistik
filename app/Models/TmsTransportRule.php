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
            'description' => 'The description of the rule in non-programmer terms.',
            'condition_field' => 'type of transport',
            'condition_content' => 'Stuckgut',
            'condition_operator' => 'equal',
            'consequence' => '...then the price is 100. A description what will happen, if the condition is met. If the type_of_transport is Stuckgut, then the Partner should be automatically Partner Emons Villingen (when processing the pamyra json file)',
        ],
    ];
}
