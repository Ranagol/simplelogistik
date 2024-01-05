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
            /**
             * The id must be nullable, because of create. But must be validated, because of edit.
             */
            'id' => 'nullable|integer|exists:tms_addresses,id',
            'company_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address_type' => 'required|string|max:255',//this is a mutator. TmsAddress::setAddressTypeAttribute() will be called.
            'street' => 'required|string|max:200',
            'house_number' => 'required|string|max:200',
            'zip_code' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'country_id' => 'required|string',//this is a mutator. TmsAddress::setCountryIdAttribute() will be called.
            'state' => 'required|string|max:100',
            'phone' => 'required|string|max:100',
            'email' => 'required|string|max:100',
            'address_additional_information' => 'required|string|max:255',
            'customer_id' => 'required|integer|exists:tms_customers,id',
            'forwarder_id' => 'required|integer|exists:tms_forwarders,id',
        ];
    }
}
