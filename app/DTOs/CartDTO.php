<?php

namespace App\DTOs;

readonly class CartDTO
{
    public function __construct(
        public ?int $productId,
        public int $brandId,
        public ?int $quantity,
        public bool $stockAlert,
        public ?string $couponCode,

    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            productId: $data['productId'] ?? null,
            brandId: $data['brandId'],
            quantity: $data['quantity'] ?? null,
            stockAlert: $data['stockAlert'],
            couponCode: $data['couponCode'] ?? null,
        );
    }
}
