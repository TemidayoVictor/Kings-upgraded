<?php
namespace App\DTOs\Dropshipper;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
class DropshipperDetailsDTO
{
    public function __construct(
        public readonly TemporaryUploadedFile|null $logo,
        public readonly string $username,
        public readonly string $bankName,
        public readonly string $accountNumber,
        public readonly string $accountName,
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
