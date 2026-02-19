<?php
namespace App\DTOs\Auth;
class SendVerificationCodeDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly string $name,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            email: $data['email'],
            name: $data['name'],
        );
    }
}
