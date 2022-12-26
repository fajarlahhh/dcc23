<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Onceperdaywithdrawalrule implements Rule
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
        //
        return auth()->user()->withdrawal->filter(function ($item) {
            return false !== stristr($item->created_at, date('Y-m-d'));
        })->count() == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'WD can only be done once a day.';
    }
}
