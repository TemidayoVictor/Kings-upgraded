<?php
namespace App\DTOs\Brand;
class SectionDTO
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $sectionId = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            sectionId: $data['sectionId'] ?? null,
        );
    }
}
