<?php

namespace App\Http\Requests\Discount;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscountRequest extends FormRequest
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
            'discount_code_name' => ['nullable','string', 'unique:discount_codes'],
            'extend_date' =>  ['nullable','date'],
            'expired_date' => ['nullable','date'],
            'status' =>  ['nullable','string'],
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
            'discount_code_name.string' => 'Discount is string',
            'discount_code_name.unique:discount_codes' => 'Discount is unique',

            'extend_date.date' => 'Extend date must be dateTime type',

            'expired_date.date' => 'Expire date must be dateTime type',

            'status.string' => 'status is string',
        ];
    }
}