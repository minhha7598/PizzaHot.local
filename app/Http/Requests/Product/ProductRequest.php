<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'product_name' => ['required','string','unique:products'],
            'price' => ['required','string'],
            'quantity' => ['required','integer'],
            'photo' => ['nullable','image','mimes:jpg,png,jpeg,gif,svg','max:2048'],
            'discount_code_id' => ['nullable','integer'],
            'category_id' => ['required','integer'],
            'imported_product_id' => ['required','integer'],
        ];
    }
}