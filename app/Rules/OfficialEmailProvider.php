<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class OfficialEmailProvider implements ValidationRule
{
    /**
     * Whitelisted email providers
     */
    private const ALLOWED_PROVIDERS = [
        'gmail.com',
        'outlook.com',
        'hotmail.com',
        'yahoo.com',
    ];

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Extract domain from email
        $domain = strtolower(substr(strrchr($value, '@'), 1));

        if (! in_array($domain, self::ALLOWED_PROVIDERS)) {
            $fail('The :attribute must be from an official email provider (Gmail, Outlook, Hotmail, or Yahoo).');
        }
    }
}
