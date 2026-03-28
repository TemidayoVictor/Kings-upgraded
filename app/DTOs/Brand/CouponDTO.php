<?php

namespace App\DTOs\Brand;

readonly class CouponDTO
{
    public function __construct(
        public ?int $id,
        public ?int $brandId,
        public string $code,
        public string $type,
        public string $value,
        public string $startsAt,
        public string $expiresAt,

    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            brandId: $data['brandId'] ?? null,
            code: $data['code'],
            type: $data['type'],
            value: $data['value'],
            startsAt: $data['startsAt'],
            expiresAt: $data['expiresAt'],

        );
    }
}
