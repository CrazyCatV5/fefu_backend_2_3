<?php

namespace App\Sanitizers;

class PhoneSanitizer
{
    public static function sanitize(?string $phoneNumber) : ?string {
        if ($phoneNumber === null) {
            return null;
        }
        $number = preg_replace('/\D+/', '', $phoneNumber);
        $number[0] = '7';
        return $number;
    }
}
