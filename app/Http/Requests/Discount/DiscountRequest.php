<?php

namespace App\Http\Requests\Discount;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
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
            'discount_code_name' => ['required','string', 'unique:discount_codes'],
            'extend_date' =>  ['required','date'],
            'expired_date' => ['required','date'],
            'status' =>  ['required','string'],
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
            'discount_code_name.required' => 'discount is required',
            'discount_code_name.string' => 'discount is string',
            'discount_code_name.unique:discount_codes' => 'discount is unique',

            'extend_date.date' => 'Extend date must be dateTime type',
            'extend_date.integer' => 'Extend date must be required',

            'expired_date.date' => 'Expire date must be dateTime type',
            'expired_date.integer' => 'Expire date must be required',

            'status.required' => 'id is required',
            'status.string' => 'id is string',
        ];
    }
}