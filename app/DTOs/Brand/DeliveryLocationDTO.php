<?php
namespace App\DTOs\Brand;
class DeliveryLocationDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $brandId,
        public readonly ?string $name,
        public readonly ?int $deliveryPrice,
        public readonly ?int $parentId,
        public readonly ?int $level,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            brandId: $data['brandId'] ?? null,
            name: $data['name'] ?? null,
            deliveryPrice: $data['deliveryPrice'] ?? null,
            parentId: $data['parentId'] ?? null,
            level: $data['level'] ?? null,
        );
    }
}
