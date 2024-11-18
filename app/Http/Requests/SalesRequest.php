<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesRequest extends FormRequest
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
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'reference_no' => 'required|string|max:255',
            'biller' => 'required|string|max:255',
            'customer_id' => 'required|exists:customers,id',
            'order_tax' => 'nullable|string|max:255',
            'order_discount' => 'nullable|in:none,pwd,senior',
            'shipping' => 'nullable|string|max:255',
            'attached_document' => 'nullable|file',
            'sale_status' => 'required|string|max:255',
            'payment_status' => 'required|string|max:255',
            'sales_note' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Please select a product.',
            'product_id.array' => 'Invalid product selection.',
            'product_id.*.exists' => 'One or more selected products do not exist.',
            'reference_no.required' => 'Please enter a reference number.',
            'biller.required' => 'Please enter the biller name.',
            'customer_id.required' => 'Please select a customer.',
            'customer_id.exists' => 'The selected customer does not exist.',
            'attached_document.required' => 'Please attach the required document.',
            'attached_document.file' => 'The attached document must be a file.',
            'attached_document.mimes' => 'The attached document must be a file of type: pdf, jpg, jpeg, png.',
            'attached_document.max' => 'The attached document must not be greater than 2MB.',
            'sale_status.required' => 'Please select a sale status.',
            'payment_status.required' => 'Please select a payment status.',
        ];
    }
}
