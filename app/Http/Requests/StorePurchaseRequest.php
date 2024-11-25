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
            'purchase_no' => 'required|string|unique:purchases,purchase_no',
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'shipping' => 'required|string|min:0',
            'notes' => 'nullable|string|max:255'
        ];
    }
}
