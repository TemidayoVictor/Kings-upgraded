<?php
namespace App\DTOs\Brand;
class BrandSettingsDTO
{
    public function __construct(
        public readonly string $brandName,
        public readonly string $selectedCategory,
        public readonly string $selectedSubcategory,
        public readonly string $description,
        public readonly string $type,
        public readonly string $position,
        public readonly string $selectedState,
        public readonly string $selectedLocalGovernment,
        public readonly string $address,
        public readonly string $bankName,
        public readonly string $accountNumber,
        public readonly string $accountName,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            brandName: $data['brandName'],
            selectedCategory: $data['selectedCategory'],
            selectedSubcategory: $data['selectedSubcategory'],
            description: $data['description'],
            type: $data['type'],
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
