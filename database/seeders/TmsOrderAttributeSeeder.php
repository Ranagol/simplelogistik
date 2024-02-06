<?php

namespace Database\Seeders;

use App\Models\TmsOrderAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsOrderAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributes = TmsOrderAttribute::RAW_ATTRIBUTES_FROM_PAMYRA;
        foreach ($attributes as $attribute) {

            TmsOrderAttribute::factory()->create(
                [
                    'name' => $this->transformCamelCaseToNormalText($attribute),
                    'name_from_partner' => $attribute,
                ]
            );
        }
    }

    /**
     * This function uses a regular expression to insert a space before each uppercase letter that 
     * is preceded by a lowercase letter or a digit. The ucfirst function capitalizes the first 
     * letter of the string, and the strtolower function converts the rest of the string to 
     * lowercase.You can use this function to transform 'clocklikeDelivery' into 'Clocklike 
     * delivery'.
     *
     * @param string $string
     * @return void
     */
    public function transformCamelCaseToNormalText(string $string)
    {
        $result = preg_replace('/(?<=\\w)(?=[A-Z])/'," $1", $string);
        return ucfirst(strtolower($result));
    }
}
