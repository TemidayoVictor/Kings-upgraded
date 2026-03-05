<?php
namespace App\DTOs\Brand;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
class ProductDTO
{
    /**
     * @param array<TemporaryUploadedFile> $images
     */
    public function __construct(
        public readonly ?array $images,
        public readonly string $name,
        public readonly string $description,
        public readonly int $price,
        public readonly int|null $salesPrice,
        public readonly int|null $dropshippingPrice,
        public readonly int|null $sectionId,
        public readonly string|null $link,
        public readonly int|null $stock,
        public readonly ?int $productId,
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
