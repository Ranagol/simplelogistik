<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TmsAddressRequest extends FormRequest
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
            'company_name' => 'nullable|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'address_type' => 'required|string|max:255',
            'street' => 'required|string|max:200',
            'house_number' => 'nullable|string|max:200',
            'zip_code' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'country_id' => 'required|integer|exists:tms_countries,id',
            'state' => 'nullable|string|max:100',
            'address_additional_information' => 'nullable|string|max:255',
            // 'customer_id' => 'nullable|integer',
            // 'forwarder_id' => 'nullable|integer',
            'customer_id' => 'nullable|integer|exists:tms_customers,id',
            'forwarder_id' => 'nullable|integer|exists:tms_forwarders,id',
        ];
    }
}
