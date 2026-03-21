<?php
namespace App\DTOs;
readonly class ProfileSettingsDTO
{
    public function __construct(
        public string $name,
        public string $phone,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            phone: $data['phone'],
        );
    }
}
