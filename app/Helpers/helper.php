<?php
if (!function_exists('firstName')) {
    function firstName(?string $fullName): string
    {
        if (empty($fullName)) {
            return '';
        }

        return explode(' ', trim($fullName))[0];
    }
}

if (!function_exists('lastName')) {
    function lastName(?string $fullName): ?string
    {
        if (empty($fullName)) {
            return null;
        }

        $parts = explode(' ', trim($fullName));
        return count($parts) > 1 ? implode(' ', array_slice($parts, 1)) : null;
    }
}
