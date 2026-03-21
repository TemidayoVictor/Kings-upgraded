<?php
namespace App\DTOs;
readonly class SelectRoleDTO
{
    public function __construct(
        public string $role,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            role: $data['role']
        );
    }
}
