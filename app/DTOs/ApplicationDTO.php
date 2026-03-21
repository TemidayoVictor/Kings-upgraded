<?php

namespace App\DTOs;

readonly class ApplicationDTO
{
    public function __construct(
        public ?int $id,
        public ?int $dropshipperId,
        public ?int $brandId,
        public ?string $notes,
        public ?string $status,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            dropshipperId: $data['dropshipperId'] ?? null,
            brandId: $data['brandId'] ?? null,
            notes: $data['notes'] ?? null,
            status: $data['status'] ?? null,
        );
    }
}
