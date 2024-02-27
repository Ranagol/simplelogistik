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
     */
    public function rules()
    {
        return $this->vehicleRules();
    }

    /**
     * This is reusable!
     *
     * @return void
     */
    public function vehicleRules()
    {
        return [
            'forwarder_id' => ['nullable', 'integer', 'exists:tms_forwarders,id'],
            'address_id' => ['nullable', 'integer', 'exists:tms_addresses,id'],
            'name' => ['nullable', 'string', 'max:100'],
            'max_weight' => ['nullable', 'numeric', ],
            'max_pickup_weight' => ['nullable', 'numeric', ],
            'max_pickup_width' => ['nullable', 'numeric', ],
            'max_pickup_height' => ['nullable', 'numeric', ],
            'max_pickup_length' => ['nullable', 'numeric', ],
            'vehicle_type' => ['nullable', 'string', 'max:100'],
            'plate_number' => ['nullable', 'string', 'max:100'],
        ];
    }
}
