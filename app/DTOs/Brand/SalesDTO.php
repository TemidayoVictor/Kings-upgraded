<?php

namespace App\DTOs\Brand;


readonly class SalesDTO
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $description,
        public string $saleMode,
        public string $discountType,
        public string $discountValue,
        public string $startsAt,
        public string $section,
        public string $endsAt,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'],
            description: $data['description'] ?? null,
            saleMode: $data['saleMode'] ?? null,
            discountType: $data['discountType'],
            discountValue: $data['discountValue'],
            startsAt: $data['startsAt'],
            section: $data['section'],
            endsAt: $data['endsAt'],
        );
    }
}
