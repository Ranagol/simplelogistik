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
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'address_type' => 'required|string|max:255',
            'street' => 'required|string|max:200',
            'house_number' => 'nullable|string|max:200',
            'zip_code' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            // 'type_of_address' => 'nullable|string|max:255',
            'comment' => 'nullable|string|max:255',
            'customer_id' => 'nullable|integer',
            'forwarder_id' => 'nullable|integer',
        ];
        // 'customer_id' => 'nullable|integer|exists:tms_customers,id',
        // 'forwarder_id' => 'nullable|integer|exists:tms_forwarders,id',
    }
}
