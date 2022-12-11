<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'name' => ['nullable','string'],
            'birthdate' =>  ['nullable','date'],
            'address' => ['nullable','string'],
            'hired_date' =>  ['nullable','date'],
            'email' => ['nullable','string', 'unique:employees','email'],
            'phone_number' =>  ['nullable','string'],
            'photo' =>  ['nullable','image'],
            'department_id' => ['nullable','integer'],
            'salary_id' =>  ['nullable','integer'],
        ];
    }
}