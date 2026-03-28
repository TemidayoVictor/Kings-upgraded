<?php

namespace App\DTOs\Brand;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

readonly class ProductDTO
{
    /**
     * @param  array<TemporaryUploadedFile>  $images
     */
    public function __construct(
        public ?array $images,
        public string $name,
        public string $description,
        public int $price,
        public ?int $salesPrice,
        public ?int $dropshippingPrice,
        public ?int $sectionId,
        public ?string $link,
        public ?int $stock,
        public ?int $productId,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            images: $data['images'] ?? [],
            name: $data['name'],
            description: $data['description'],
            price: $data['price'],
            salesPrice: $data['salesPrice'],
            dropshippingPrice: $data['dropshippingPrice'],
            sectionId: $data['sectionId'],
            link: $data['link'],
            stock: $data['stock'],
            productId: $data['productId'] ?? 0,
        );
    }
}
