<?php
namespace App\Enums;

class UserType
{
    const CLIENT = 'client';
    const BRAND = 'brand';
    const DROPSHIPPER = 'dropshipper';
    const ADMIN = 'admin'; // example third type

    // Optional: get all types
    public static function all(): array
    {
        return [
            self::CLIENT,
            self::BRAND,
            self::DROPSHIPPER,
            self::ADMIN,
        ];
    }
}
