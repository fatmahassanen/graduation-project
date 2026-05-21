<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class EgyptianPhone implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Must be exactly 11 digits
        if (! preg_match('/^\d{11}$/', $value)) {
            $fail('The :attribute must be exactly 11 digits.');

            return;
        }

        // Must start with valid Egyptian mobile prefixes
        $validPrefixes = ['010', '011', '012', '015'];
        $prefix = substr($value, 0, 3);

        if (! in_array($prefix, $validPrefixes)) {
            $fail('The :attribute must start with 010, 011, 012, or 015.');
        }
    }
}
