<?php

namespace App\Enums;

class Status
{
    const ACTIVE = 'active';

    const INACTIVE = 'inactive';

    const UNLISTED = 'unlisted';

    const SUSPENDED = 'suspended';
    const SUSPENDED_BY_ADMIN = 'suspended-by-admin';

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

    const GENERIC = 'generic';

    const DYNAMIC = 'dynamic';

    const UPGRADE = 'upgrade';

    const INCREMENT = 'increment';

    const RENEWAL = 'renewal';

    const SERVICE = 'service';

    const PRODUCT = 'product';

    const MONTHLY = 'monthly';

    const COMMISSION = 'commission';

    const DEACTIVATED = 'deactivated';

    // Optional: get all types
    public static function all(): array
    {
        return [
            self::ACTIVE,
            self::INACTIVE,
            self::UNLISTED,
            self::SUSPENDED,
            self::SUSPENDED_BY_ADMIN,
            self::COMPLETED,
            self::BASIC,
            self::PREMIUM,
            self::PLATINUM,
            self::APPROVED,
            self::PENDING,
            self::REJECTED,
            self::CLONED,
            self::FAILED,
            self::PAID,
            self::PROCESSING,
            self::SHIPPED,
            self::DELIVERED,
            self::CANCELLED,
            self::GENERIC,
            self::DYNAMIC,
            self::UPGRADE,
            self::INCREMENT,
            self::RENEWAL,
            self::SERVICE,
            self::PRODUCT,
            self::MONTHLY,
            self::COMMISSION,
            self::DEACTIVATED,
        ];
    }
}
