<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\OrderQuantityRule;

class ShipRequest extends FormRequest
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
    public function rules():array
    {
        return [
            'products' => ['required', new OrderQuantityRule()],
            'products.*.product_id' => ['required','integer'],
            'products.*.order_quantity' => ['required','integer'],
            'ship_address' => ['required','string'],
            'phone_number' => ['required','string'],
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
            'ship_address.required' => 'Ship address is required',
            'ship_address.string' => 'Ship address must be string',
            'products.*.product_id.required' => 'Product is required',
            'products.*.order_quantity.required' => 'Order quantity is required',
            'products.*.product_id.integer' => 'Product must be integer',
            'products.*.order_quantity.integer' => 'Order quantity must be integer',
        ];
    }
}