<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReturnsRequest extends FormRequest
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
            'date_added' => 'required|date',
            'reference_no' => 'required|string|unique:returns,reference_no',
            'biller' => 'required|string',
            'customer_id' => 'required|integer|exists:customers,id',
            'order_tax' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'shipping' => 'required|string|min:0',
            'attach_document' => 'required|file',
            'return_notes' => 'nullable|string|max:255'
        ];
    }
}
