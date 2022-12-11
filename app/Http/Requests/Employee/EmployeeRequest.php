<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'name' => ['required','string'],
            'birthdate' =>  ['required','date'],
            'address' => ['required','string'],
            'hired_date' =>  ['required','date'],
            'email' => ['required','string', 'unique:employees','email'],
            'phone_number' =>  ['required','string'],
            'photo' =>  ['nullable','image'],
            'department_id' => ['required','integer'],
            'salary_id' =>  ['required','integer'],
        ];
    }
}