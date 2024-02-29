<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CreditCardIsValid implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = str_split($value);
        if (count($value) != 16) {
            $fail('invalid card');
        }
        $isOdd = false;
        $array = array_map(function ($item) use (&$isOdd) {
            $n = intval($item);
            $n *= $isOdd ? 1 : 2;
            if ($n > 9) {
                $n -= 9;
            }
            $isOdd = !$isOdd;
            return $n;
        }, $value);
        if (array_sum($array) % 10 !== 0) {
            $fail('invalid card');
        }
    }
}
