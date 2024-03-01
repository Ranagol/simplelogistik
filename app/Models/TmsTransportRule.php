<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmsTransportRule extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'tms_transport_rules';

    /**
     * The trasport rules defined by Francesco.
     */
    // public const TRANSPORT_RULES = [
    // ];
    
    public const TRANSPORT_RULE_ARRAYS = [
        [
            'action_type' => 'setForwarder',
            'source_field' => 'calculationModelName',
            'condition_operator' => 'contains',
            'keyphrase' => 'Stückgut',
            'target_table_name' => 'tms_orders',
            'target_column_name' => 'forwarder_id',
            'target_new_value' => '1',
            'description' => 'If the type_of_transport is Stuckgut, then the forwarder should be automatically Emons',
        ],
        [
            'action_type' => 'setTypeOfTransport',
            'source_field' => 'calculationModelName',
            'condition_operator' => 'contains',
            'keyphrase' => 'FTL / LTL',
            'target_table_name' => 'tms_orders',
            'target_column_name' => 'type_of_transport',
            'target_new_value' => 'FTL / LTL',
            'description' => 'FTL/LTL when FTL LTL is mentioned',
        ],
        [
            'action_type' => 'setTypeOfTransport',
            'source_field' => 'calculationModelName',
            'condition_operator' => 'contains',
            'keyphrase' => 'Planensprinter',
            'target_table_name' => 'tms_orders',
            'target_column_name' => 'type_of_transport',
            'target_new_value' => 'FTL / LTL',
            'description' => 'FTL/LTL when Planensprinter is mentioned',
        ],
        [
            'action_type' => 'setTypeOfTransport',
            'source_field' => 'calculationModelName',
            'condition_operator' => 'contains',
            'keyphrase' => 'Stückgut',
            'target_table_name' => 'tms_orders',
            'target_column_name' => 'type_of_transport',
            'target_new_value' => 'Stückgut',
            'description' => '',
        ],
        [
            'action_type' => 'setTypeOfTransport',
            'source_field' => 'calculationModelName',
            'condition_operator' => 'contains',
            'keyphrase' => 'Directfahrt',
            'target_table_name' => 'tms_orders',
            'target_column_name' => 'type_of_transport',
            'target_new_value' => 'Directfahrt',
            'description' => '',
        ],
        [
            'action_type' => 'setTypeOfTransport',
            'source_field' => 'calculationModelName',
            'condition_operator' => 'contains',
            'keyphrase' => 'Sperrgut',
            'target_table_name' => 'tms_orders',
            'target_column_name' => 'type_of_transport',
            'target_new_value' => 'Stückgut',
            'description' => '',
        ],
    ];
}
