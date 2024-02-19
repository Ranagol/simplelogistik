<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TmsForwarderRequest extends FormRequest
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
    public function rules()
    {
        return $this->forwarderRules();
    }

    /**
     * This is reusable!
     *
     * @return void
     */
    public function forwarderRules()
    {

        return [
            'id' => ['required', 'integer', 'min:1'],
            'company_name' => ['required', 'string', 'max:200'],
            'internal_id' => ['required', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:200'],
            'tax_number' => ['nullable', 'string', 'max:200'],
            'rating' => ['nullable', 'integer', 'min:1'],
            'forwarder_type' => ['nullable', 'integer', 'min:1'],
            'comments' => ['nullable', 'string'],
            'url_logo' => ['nullable', 'url'],
        ];
    }
}
