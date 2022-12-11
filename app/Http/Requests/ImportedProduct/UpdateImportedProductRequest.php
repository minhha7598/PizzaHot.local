<?php

namespace App\Http\Requests\ImportedProduct;

use Illuminate\Foundation\Http\FormRequest;

class UpdateImportedProductRequest extends FormRequest
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
            'id' => ['required','integer'],
            'cost' => ['required','string'],
            'quantity' => ['required','integer'],
            'cost_total' => ['required','string'],
            'date' => ['nullable','date'],
        ];
    }
}