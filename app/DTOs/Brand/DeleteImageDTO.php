<?php
namespace App\DTOs\Brand;
class DeleteImageDTO
{
    public function __construct(
        public readonly int $productId,
        public readonly int $imageId,
        public readonly ?bool $override,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            productId: $data['productId'],
            imageId: $data['imageId'],
            override: $data['override'] ?? false

        );
    }
}
