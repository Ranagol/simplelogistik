<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TmsTransportRuleSeeder extends Seeder
{
    private array $rules = [
        "INSERT INTO simplelogistik.tms_transport_rules (id, action_type, source_field, condition_operator, keyphrase, target_table_name, target_column_name, target_new_value, description, created_at, updated_at)VALUES(1, 'setPartner', 'calculationModelName', 'contains', 'Stückgut', 'tms_orders', 'partner_id', '2', 'If the type_of_transport is Stuckgut, then the partner should be automatically Emons Villingen.', NULL, NULL);",
        "INSERT INTO simplelogistik.tms_transport_rules (id, action_type, source_field, condition_operator, keyphrase, target_table_name, target_column_name, target_new_value, description, created_at, updated_at) VALUES(2, 'setTypeOfTransport', 'calculationModelName', 'contains', 'FTL / LTL', 'tms_orders', 'type_of_transport', 'FTL / LTL', 'FTL/LTL when FTL LTL is mentioned', NULL, NULL);",
        "INSERT INTO simplelogistik.tms_transport_rules (id, action_type, source_field, condition_operator, keyphrase, target_table_name, target_column_name, target_new_value, description, created_at, updated_at) VALUES(3, 'setTypeOfTransport', 'calculationModelName', 'contains', 'Planensprinter', 'tms_orders', 'type_of_transport', 'FTL / LTL', 'FTL/LTL when Planensprinter is mentioned', NULL, NULL);",
        "INSERT INTO simplelogistik.tms_transport_rules (id, action_type, source_field, condition_operator, keyphrase, target_table_name, target_column_name, target_new_value, description, created_at, updated_at) VALUES(4, 'setTypeOfTransport', 'calculationModelName', 'contains', 'Stückgut', 'tms_orders', 'type_of_transport', 'Stückgut', '', NULL, NULL);",
        "INSERT INTO simplelogistik.tms_transport_rules (id, action_type, source_field, condition_operator, keyphrase, target_table_name, target_column_name, target_new_value, description, created_at, updated_at) VALUES(5, 'setTypeOfTransport', 'calculationModelName', 'contains', 'Directfahrt', 'tms_orders', 'type_of_transport', 'Directfahrt', '', NULL, NULL);",
    ];
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->rules as $rule) {
            DB::statement($rule);
        }
    }
}
