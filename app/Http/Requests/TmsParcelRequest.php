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
        return $this->parcelRules();
    }

    public function parcelRules()
    {
        return [
            'tms_order_id' => ['required', 'integer', 'exists:tms_orders,id'],
            'is_hazardous' => ['boolean'],
            'information' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'height' => ['required', 'numeric', 'between:0,9999999999.99'],
            'length' => ['required', 'numeric', 'between:0,9999999999.99'],
            'width' => ['required', 'numeric', 'between:0,9999999999.99'],
            'number' => ['required', 'numeric'], //This is a property of Pamyra orders. Number is an index of transport objects.
            'stackable' => ['boolean'],
            'weight' => ['required', 'numeric', 'between:0,9999999999.99'],
        ];
    }
}
