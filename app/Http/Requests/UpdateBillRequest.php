<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\OrderQuantityRule;

class UpdateBillRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
                'id' => ['required', 'integer'],
                'order_date' => ['nullable', 'date_format:"Y-m-d H:i:s"'],
                'phone_number' => ['nullable', 'string'],
                'ship_address' => ['nullable', 'string'],
                'number_table' => ['nullable', 'integer'],
                'products' => ['nullable', new OrderQuantityRule()],
                'products.*.product_id' => ['required','integer'],
                'products.*.order_quantity' => ['required','integer'],
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'id.required' => 'Id must be required',
            'id.integer' => 'Id must be integer',
            'order_date.date_format:"Y-m-d H:i:s"' => 'Table must be dateTime type',
            'phone_number.string' => 'Phone number must be string',
            'number_table.integer' => 'Number table must be integer',
            'products.*.product_id.required' => 'Product id must be required',
            'products.*.product_id.integer' => 'Product id must be integer',
            'products.*.order_quantity.required' => 'Quantity must be required',
            'products.*.order_quantity.integer' => 'Quantity must be integer',
        ];
    }
}