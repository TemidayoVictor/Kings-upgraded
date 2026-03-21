<?php
namespace App\DTOs;
readonly class GeneralDTO
{
    public function __construct(
        public int $id,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id']
        );
    }
}
