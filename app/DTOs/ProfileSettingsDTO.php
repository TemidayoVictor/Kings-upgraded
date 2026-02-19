<?php
namespace App\DTOs;
class ProfileSettingsDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $phone,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            phone: $data['phone'],
        );
    }
}
