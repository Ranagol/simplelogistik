<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TmsCargoOrderRequest extends FormRequest
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
            'order_number' => 'required|string|max:200',
            'customer_id' => 'required|integer|exists:tms_customers,id',
            'contact_id' => 'required|integer|exists:tms_contacts,id',
            'pickup_address_id' => 'required|integer|exists:tms_addresses,id',
            'delivery_address_id' => 'required|integer|exists:tms_addresses,id',
            'description' => 'required|string|max:255',
            'shipping_price' => 'required|numeric|between:0,9999999999.99',
            'shipping_price_netto' => 'required|numeric|between:0,9999999999.99',
            'pickup_date' => 'required|date',
            'delivery_date' => 'required|date',
            // 'pickup_date' => 'nullable|date',
            // 'delivery_date' => 'nullable|date',
        ];
    }
}
