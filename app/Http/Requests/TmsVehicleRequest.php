<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TmsVehicleRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'max_weight' => 'required|numeric|between:0,99999999.99',
            'max_pickup_weight' => 'required|numeric|between:0,99999999.99',
            'max_pickup_width' => 'required|numeric|between:0,99999999.99',
            'max_pickup_height' => 'required|numeric|between:0,99999999.99',
            'max_pickup_length' => 'required|numeric|between:0,99999999.99',
            'vehicle_type' => 'required|string|max:100',
            'plate_number' => 'required|string|max:50',
            'forwarder_id' => 'required|integer',
            'address_id' => 'required|integer',
        ];
        // 'forwarder_id' => 'required|integer|exists:tms_forwarders,id',
        // 'address_id' => 'required|integer|exists:tms_addresses,id',
        
    }
}
