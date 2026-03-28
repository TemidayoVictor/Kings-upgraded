<?php
namespace App\DTOs\Brand;
readonly class BrandSettingsDTO
{
    public function __construct(
        public string $brandName,
        public string $selectedCategory,
        public string $selectedSubcategory,
        public string $description,
        public string $type,
        public string $slug,
        public string $position,
        public string $selectedState,
        public string $selectedLocalGovernment,
        public string $address,
        public string $bankName,
        public string $accountNumber,
        public string $accountName,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            brandName: $data['brandName'],
            selectedCategory: $data['selectedCategory'],
            selectedSubcategory: $data['selectedSubcategory'],
            description: $data['description'],
            type: $data['type'],
            slug: $data['slug'],
            position: $data['position'],
            selectedState: $data['selectedState'],
            selectedLocalGovernment: $data['selectedLocalGovernment'],
            address: $data['address'],
            bankName: $data['bankName'],
            accountNumber: $data['accountNumber'],
            accountName: $data['accountName']
        );
    }
}
