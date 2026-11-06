<?php

namespace App\DTOs\Brand;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

readonly class CatalogDTO
{
    /**
     * @param  array<TemporaryUploadedFile>  $photos
     */
    public function __construct(
        public int $brandId,
        public ?array $photos,
        public ?int $skippedFiles,
        public ?int $catalogId,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            brandId: $data['brandId'],
            photos: $data['photos'] ?? [],
            skippedFiles: $data['skippedFiles'] ?? null,
            catalogId: $data['catalogId'] ?? null,
        );
    }
}
