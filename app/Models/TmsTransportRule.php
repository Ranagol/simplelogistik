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
    public const TRANSPORT_RULES = [
        "INSERT INTO simplelogistik.tms_transport_rules (id, action_type, source_field, condition_operator, keyphrase, target_table_name, target_column_name, target_new_value, description, created_at, updated_at) VALUES(1, 'setForwarder', 'calculationModelName', 'contains', 'Stückgut', 'tms_orders', 'forwarder_id', '1', 'If the type_of_transport is Stuckgut, then the forwarder should be automatically Emons', NULL, NULL);",
        "INSERT INTO simplelogistik.tms_transport_rules (id, action_type, source_field, condition_operator, keyphrase, target_table_name, target_column_name, target_new_value, description, created_at, updated_at) VALUES(2, 'setTypeOfTransport', 'calculationModelName', 'contains', 'FTL / LTL', 'tms_orders', 'type_of_transport', 'FTL / LTL', 'FTL/LTL when FTL LTL is mentioned', NULL, NULL);",
        "INSERT INTO simplelogistik.tms_transport_rules (id, action_type, source_field, condition_operator, keyphrase, target_table_name, target_column_name, target_new_value, description, created_at, updated_at) VALUES(3, 'setTypeOfTransport', 'calculationModelName', 'contains', 'Planensprinter', 'tms_orders', 'type_of_transport', 'FTL / LTL', 'FTL/LTL when Planensprinter is mentioned', NULL, NULL);",
        "INSERT INTO simplelogistik.tms_transport_rules (id, action_type, source_field, condition_operator, keyphrase, target_table_name, target_column_name, target_new_value, description, created_at, updated_at) VALUES(4, 'setTypeOfTransport', 'calculationModelName', 'contains', 'Stückgut', 'tms_orders', 'type_of_transport', 'Stückgut', '', NULL, NULL);",
        "INSERT INTO simplelogistik.tms_transport_rules (id, action_type, source_field, condition_operator, keyphrase, target_table_name, target_column_name, target_new_value, description, created_at, updated_at) VALUES(5, 'setTypeOfTransport', 'calculationModelName', 'contains', 'Directfahrt', 'tms_orders', 'type_of_transport', 'Directfahrt', '', NULL, NULL);",
        "INSERT INTO simplelogistik.tms_transport_rules (id, action_type, source_field, condition_operator, keyphrase, target_table_name, target_column_name, target_new_value, description, created_at, updated_at) VALUES(6, 'setTypeOfTransport', 'calculationModelName', 'contains', 'Sperrgut', 'tms_orders', 'type_of_transport', 'Stückgut', '', NULL, NULL);",
    ];
}
