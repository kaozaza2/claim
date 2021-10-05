<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Identification implements Rule
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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (strlen($value) != 13)
            return false;

        $calculate = (substr($value, 0, 1) * 13)
            + (substr($value, 1, 1) * 12)
            + (substr($value, 2, 1) * 11)
            + (substr($value, 3, 1) * 10)
            + (substr($value, 4, 1) * 9)
            + (substr($value, 5, 1) * 8)
            + (substr($value, 6, 1) * 7)
            + (substr($value, 7, 1) * 6)
            + (substr($value, 8, 1) * 5)
            + (substr($value, 9, 1) * 4)
            + (substr($value, 10, 1) * 3)
            + (substr($value, 11, 1) * 2);

        return 11 - ($calculate % 11) == substr($value, 12, 1);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute id is invalid';
    }
}
