<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidBirthNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!$this->isValidCzechoSlovakBirthNumber($value)) {
            $fail('Není validní rodné číslo.');
        }
    }

    public function isValidCzechoSlovakBirthNumber($rc): bool  {
        // be liberal in what you receive
        if (!preg_match('#^\s*(\d\d)(\d\d)(\d\d)[ /]*(\d\d\d)(\d?)\s*$#', $rc, $matches)) {
            return false;
        }

        list(, $year, $month, $day, $ext, $c) = $matches;

        if ($c === '') {
            $year += $year < 54 ? 1900 : 1800;
        } else {
            // kontrolní číslice
            $mod = ($year . $month . $day . $ext) % 11;
            if ($mod === 10) $mod = 0;
            if ($mod !== (int) $c) {
                return false;
            }

            $year += $year < 54 ? 2000 : 1900;
        }

        // k měsíci může být připočteno 20, 50 nebo 70
        if ($month > 70 && $year > 2003) {
            $month -= 70;
        } elseif ($month > 50) {
            $month -= 50;
        } elseif ($month > 20 && $year > 2003) {
            $month -= 20;
        }

        // kontrola data
        if (!checkdate($month, $day, $year)) {
            return false;
        }

        return true;
    }
}
