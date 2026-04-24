<?php

namespace App\DTOs;

use Illuminate\Support\Collection;

readonly class GeneralDTO
{
    public function __construct(
        public int $id,
        public ?array $value = null,
        public ?Collection $items = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            value: $data['value'] ?? null,
            items: $data['items'] ?? null,
        );
    }
}
