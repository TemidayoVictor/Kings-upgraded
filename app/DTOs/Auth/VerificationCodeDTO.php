<?php
namespace App\DTOs\Auth;

class VerificationCodeDTO
{
    public function __construct(
        public readonly int $code,
        public readonly int $userId,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'],
            userId: $data['user_id'],
        );
    }
}
