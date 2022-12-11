<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Table;

class TablePaymentRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(is_int($value)){
            $status = Table::Where('id', '=', $value)->first()->status;
        
            if($status === 'Full'){
                return true;
            }
        }
        
        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Table is Free!';
    }
}