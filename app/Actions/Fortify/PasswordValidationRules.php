<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected function passwordRules(): array
    {
        // $passwordRule = new Password();
        // $passwordRule->requireNumeric();
        return ['required', 'string', new Password, 'confirmed'];
    }
}
