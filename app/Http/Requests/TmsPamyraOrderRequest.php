<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TmsPamyraOrderRequest extends FormRequest
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
        return $this->pamyraOrderRules();
    }

    /**
     * Do not use | pipes, use array in validation rules!
     */
    public function pamyraOrderRules()
    {
        return [
            'calculation_model_name' => ['nullable', 'string', 'max:255'],
            'order_number' => ['required', 'string', 'max:255'],
            'order_pdf' => ['nullable', 'string', 'max:255'],
            'payment_method' => ['required', 'string', 'max:255'],
            'date_of_sale' => ['required', 'date'],
            'date_of_cancellation' => ['nullable', 'date_format:Y-m-d'],
            'description_of_transport' => ['nullable', 'string', 'max:255'],
            'particularities' => ['nullable', 'string', 'max:255'],
            'loading_meter' => ['nullable', 'numeric'],
            'square_meter' => ['nullable', 'numeric'],
            'total_weight' => ['nullable', 'numeric'],
            'qubic_meter' => ['nullable', 'numeric'],
            'calculated_transport_price' => ['nullable', 'numeric'],
            'transport_price_gross' => ['nullable', 'numeric'],
            'transport_price_vat' => ['nullable', 'numeric'],
            'transport_price_net' => ['nullable', 'numeric'],
            'customized_price_change' => ['nullable', 'numeric'],
            'customized_price_mode' => ['nullable', 'string', 'max:255'],
            'discount' => ['nullable', 'numeric'],
            'price_gross' => ['nullable', 'numeric'],
            'price_vat' => ['nullable', 'numeric'],
            'price_net' => ['nullable', 'numeric'],
            'price_fuel_surcharge' => ['nullable', 'numeric'],
            'vat_rate' => ['nullable', 'numeric'],
            'value_insured' => ['nullable', 'numeric'],
            'value_of_goods' => ['nullable', 'numeric'],
            'distance_km' => ['required', 'numeric'],
            'duration_minutes' => ['nullable', 'numeric'],
        ];
    }
}
