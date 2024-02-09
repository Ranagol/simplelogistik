<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TmsEmonsInvoiceRequest extends FormRequest
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
        return $this->emonsInvoiceRules();
    }

    public function emonsInvoiceRules()
    {
        return [
            'emons_invoice_number' => 'required|string',
            'billing_date' => 'required|date',
            'order_number' => 'required|string',
            'customer_name' => 'required|string',
            'customer_country_code' => 'required|string|size:2',
            'customer_zip_code' => 'required|string',
            'customer_city' => 'required|string',
            'receiver_name' => 'required|string',
            'receiver_country_code' => 'required|string|size:2',
            'receiver_zip_code' => 'required|string',
            'receiver_city' => 'required|string',
            'netto_price' => 'required|numeric',
        ];
    }


}
