<?php
 
namespace App\Http\Requests\ValidationRules;
 
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
 
class ParcelValidationRule implements ValidationRule
{
    
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_array($value) === false) {
            $fail('The :attribute must be an object.');
            return;
        }

        // if (isset($value['tms_order_id']) === false) {
        //     $fail('The :attribute tms_order_id is required.');
        // }

        $this->isRequired(
            $value,
             'tms_order_id',
              $fail
            );

        $this->isRequired(
            $value,
                'p_name',
                $fail
            );

        if (is_int($value['tms_order_id']) === false) {
            $fail('The :attribute tms_order_id must be an integer.');
        }

        if (is_bool($value['is_hazardous']) === false) {
            $fail('The :attribute.is_hazardous must be a boolean.');
        }

        if (empty($value['p_name']) === true) {
            $fail('The :attribute.p_name can not be empty.');
        }

        // return [
        //     'tms_order_id' => 'required|integer|exists:tms_orders,id',
        //     'is_hazardous' => 'boolean',
        //     'information' => 'required|string|max:255',
        //     'p_name' => 'required|string|max:255',
        //     'p_height' => 'required|numeric|between:0,9999999999.99',
        //     'p_length' => 'required|numeric|between:0,9999999999.99',
        //     'p_width' => 'required|numeric|between:0,9999999999.99',
        //     'p_number' => 'required|string|max:255',//This is a property of Pamyra orders. Number is an index of transport objects.
        //     'p_stackable' => 'boolean',
        //     'p_weight' => 'required|numeric|between:0,9999999999.99',
        // ];
    }

    private function isRequired(array $value, string $key, Closure $fail): void
    {
        if (isset($value[$key]) === false) {
            $fail("The :attribute.$key is required.");
        }
    }
}


