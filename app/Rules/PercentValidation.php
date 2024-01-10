<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PercentValidation implements Rule
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
        $number = convertPersianToEnglish($value);
        $number = convertArabicToEnglish($number);

        if (preg_match("/^[0-9]+$/", $number) && $number <= 100 && $number > 0) {

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
        return ':attribute باید حداقل ۱ و حداکثر ۱۰۰ باشد.';
    }
}
