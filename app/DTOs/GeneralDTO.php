<?php
namespace App\DTOs;
class GeneralDTO
{
    public function __construct(
        public readonly int $id,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id']
        );
    }
}
