<?php

namespace App\DTOs\Dropshipper;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

readonly class CloneStoreDTO
{
    public function __construct(
        public string $storeName,
        public string $storeSlug,
        public int $brandId,
        public string $brandName,
        public array $settings,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            storeName: $data['storeName'],
            storeSlug: $data['storeSlug'],
            brandId: $data['brandId'],
            brandName: $data['brandName'],
            settings: $data['settings'] ?? [],
        );
    }
}
