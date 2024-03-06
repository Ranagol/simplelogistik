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
     * The trasport rules defined by Francesco. All rules defined by Francesco will be stored here,
     * and from here it will be used to seed the database.
     */
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
            'keyphrase' => 'Direktfahrt',
            'target_table_name' => 'tms_orders',
            'target_column_name' => 'type_of_transport',
            'target_new_value' => 'Direktfahrt',
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
        [
            'action_type' => 'setForwarder',
            'source_field' => 'calculationModelName',
            'condition_operator' => 'contains',
            'keyphrase' => 'FTL / LTL',
            'target_table_name' => 'tms_orders',
            'target_column_name' => 'forwarder_id',
            'target_new_value' => '2',
            'description' => '2 is TimoCom',
        ],
        //These below are only temporary dummy rules needed to Patrick. Will be changed.
        [
            'action_type' => 'setForwarder',
            'source_field' => 'calculationModelName',
            'condition_operator' => 'contains',
            'keyphrase' => 'Direktfahrt',
            'target_table_name' => 'tms_orders',
            'target_column_name' => 'forwarder_id',
            'target_new_value' => '2',
            'description' => '2 is TimoCom',
        ],
        [
            'action_type' => 'setForwarder',
            'source_field' => 'calculationModelName',
            'condition_operator' => 'contains',
            'keyphrase' => 'Planensprinter',
            'target_table_name' => 'tms_orders',
            'target_column_name' => 'forwarder_id',
            'target_new_value' => '2',
            'description' => '2 is TimoCom',
        ],
        [
            'action_type' => 'setForwarder',
            'source_field' => 'calculationModelName',
            'condition_operator' => 'contains',
            'keyphrase' => 'Sperrgut',
            'target_table_name' => 'tms_orders',
            'target_column_name' => 'forwarder_id',
            'target_new_value' => '2',
            'description' => '2 is TimoCom',
        ],
    ];
}
