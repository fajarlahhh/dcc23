<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UsernameRule implements Rule
{
    public $exist = false;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($exist = false)
    {
        //
        $this->exist = $exist;
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
        return $this->exist ? User::where('username', $value)->count() > 0 : User::where('username', $value)->count() == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->exist ? 'The :attribute not found' : 'Duplicate :attribute.';
    }
}
