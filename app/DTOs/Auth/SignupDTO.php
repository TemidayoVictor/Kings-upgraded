<?php
namespace App\DTOs\Auth;

class SignupDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $name,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email: $data['email'],
            password: $data['password'],
            name: $data['name'],
        );
    }
}
