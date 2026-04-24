<?php
namespace App\Enums;

class Status
{
    const ACTIVE = 'active';
    const UNLISTED = 'unlisted';
    const SUSPENDED = 'suspended';
    const COMPLETED = 'completed';
    const BASIC = 'basic';
    const PREMIUM = 'premium';
    const PLATINUM = 'platinum';
    const APPROVED = 'approved';
    const PENDING = 'pending';
    const REJECTED = 'rejected';
    const CLONED = 'cloned';
    const FAILED = 'failed';
    const PAID = 'paid';
    const PROCESSING = 'processing';
    const SHIPPED = 'shipped';
    const DELIVERED = 'delivered';
    const CANCELLED = 'cancelled';

    // Optional: get all types
    public static function all(): array
    {
        return [
            self::ACTIVE,
            self::UNLISTED,
            self::SUSPENDED,
            self::COMPLETED,
            self::BASIC,
            self::PREMIUM,
            self::PLATINUM,
        ];
    }
}
