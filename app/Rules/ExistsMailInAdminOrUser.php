<?php

namespace App\Rules;

use App\Models\Admin;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExistsMailInAdminOrUser implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!User::where('email', $value)->exists() && !Admin::where('email', $value)->exists()) {
            $fail(":Attribute không tồn tại.");
        }
    }
}
