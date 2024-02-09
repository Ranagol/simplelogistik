<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TmsNativeOrderRequest extends FormRequest
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
        return $this->nativeOrderRules();
    }

    public function nativeOrderRules()
    {
        return [

            /**
             * Do not use | pipes, use array in validation rules!
             */
            'calculation_model_name' => ['nullable', 'string', 'max:255'],
            'order_number' => ['nullable', 'string', 'max:255'],
            'order_pdf' => ['nullable', 'string', 'max:255'],
            'payment_method' => ['required', 'string', 'max:255'],
            'date_of_sale' => ['required', 'date'],
            'date_of_cancellation' => ['nullable', 'date_format:Y-m-d'],
            'description_of_transport' => ['nullable', 'string', 'max:255'],
            'particularities' => ['nullable', 'string', 'max:255'],
            'loading_meter' => ['nullable', 'string', 'max:255'],
            'square_meter' => ['nullable', 'string', 'max:255'],
            'total_weight' => ['nullable', 'string', 'max:255'],
            'qubic_meter' => ['nullable', 'string', 'max:255'],
            'calculated_transport_price' => ['nullable', 'string', 'max:255'],
            'transport_price_gross' => ['nullable', 'string', 'max:255'],
            'transport_price_vat' => ['nullable', 'string', 'max:255'],
            'transport_price_net' => ['nullable', 'string', 'max:255'],
            'customized_price_change' => ['nullable', 'string', 'max:255'],
            'customized_price_mode' => ['nullable', 'string', 'max:255'],
            'discount' => ['nullable', 'string', 'max:255'],
            'price_gross' => ['nullable', 'string', 'max:255'],
            'price_vat' => ['nullable', 'string', 'max:255'],
            'price_net' => ['nullable', 'string', 'max:255'],
            'price_fuel_surcharge' => ['nullable', 'string', 'max:255'],
            'vat_rate' => ['nullable', 'string', 'max:255'],
            'value_insured' => ['nullable', 'string', 'max:255'],
            'value_of_goods' => ['nullable', 'string', 'max:255'],
            'distance_km' => ['required', 'string', 'max:255'],
            'duration_minutes' => ['nullable', 'string', 'max:255'],
        ];
    }
}
