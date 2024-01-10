<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NumberValidation implements Rule
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

        $number =convertPersianToEnglish($value);
        $number = convertArabicToEnglish($number);

        if(preg_match("/^[0-9]+$/", $number)){

            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute باید شامل عدد باشد.';
    }
}
