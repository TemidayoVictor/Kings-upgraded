<?php

namespace App\DTOs\Dropshipper;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

readonly class DropshipperDetailsDTO
{
    public function __construct(
        public ?TemporaryUploadedFile $logo,
        public string $username,
        public string $bankName,
        public string $accountNumber,
        public string $accountName,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            logo: $data['logo'],
            username: $data['username'],
            bankName: $data['bankName'],
            accountNumber: $data['accountNumber'],
            accountName: $data['accountName']
        );
    }
}
