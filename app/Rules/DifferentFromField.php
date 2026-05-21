<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class DifferentFromField implements ValidationRule
{
    protected string $otherField;

    protected string $otherFieldName;

    /**
     * Create a new rule instance.
     *
     * @param  string  $otherField  The field name to compare against
     * @param  string  $otherFieldName  The display name for error message
     */
    public function __construct(string $otherField, string $otherFieldName)
    {
        $this->otherField = $otherField;
        $this->otherFieldName = $otherFieldName;
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $otherValue = request()->input($this->otherField);

        if ($value === $otherValue) {
            $fail("The :attribute must be different from {$this->otherFieldName}.");
        }
    }
}
