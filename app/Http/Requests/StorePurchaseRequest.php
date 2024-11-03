<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
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
            'purchase_no' => 'required|string|unique:purchases,purchase_no',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'is_received' => 'required|boolean',
            'order_tax' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'shipping' => 'required|string|min:0',
            'payment' => 'required|string',
            'notes' => 'nullable|string|max:255'
        ];
    }
}
