<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TmsOrderAttributeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->orderAttributeRules();
    }

    public function orderAttributeRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'name_from_partner' => ['required', 'string', 'max:255'],
            'partner_id' => ['required', 'integer', 'exists:tms_partners,id'],
            'price' => ['required', 'numeric'],
            'currency' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'from_date' => ['required', 'date'],
            'to_date' => ['required', 'date'],
        ];
    }
}
