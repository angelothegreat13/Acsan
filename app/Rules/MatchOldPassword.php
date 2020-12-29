<?php

namespace App\Rules;

use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Rule;

class MatchOldPassword implements Rule
{
    public $oldPassword;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($oldPassword)
    {
        $this->oldPassword = $oldPassword;
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
        return Hash::check($value, $this->oldPassword);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is not match with old password.';
    }
}
