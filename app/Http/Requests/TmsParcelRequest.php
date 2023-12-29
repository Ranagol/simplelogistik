<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TmsParcelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tms_cargo_order_id' => 'required|integer|exists:tms_cargo_orders,id',
            'is_hazardous' => 'boolean',
            'information' => 'required|string|max:255',
            'p_name' => 'required|string|max:255',
            'p_height' => 'required|numeric|between:0,9999999999.99',
            'p_length' => 'required|numeric|between:0,9999999999.99',
            'p_width' => 'required|numeric|between:0,9999999999.99',
            'p_number' => 'required|string|max:255',//This is a property of Pamyra orders. Number is an index of transport objects.
            'p_stackable' => 'boolean',
            'p_weight' => 'required|numeric|between:0,9999999999.99',
        ];
    }
}
