<?php
namespace App\DTOs\Brand;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
class AdditionalDetailsDTO
{
    public function __construct(
        public TemporaryUploadedFile|null $logo,
        public readonly string $about,
        public readonly string $motto,
        public readonly string $instagram,
        public readonly string $tiktok,
        public readonly string $linkedin,
        public readonly string $twitter,
        public readonly string $facebook,
        public readonly string $youtube,
        public readonly string $website,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            logo: $data['logo'],
            about: $data['about'],
            motto: $data['motto'],
            instagram: $data['instagram'],
            tiktok: $data['tiktok'],
            linkedin: $data['linkedin'],
            twitter: $data['twitter'],
            facebook: $data['facebook'],
            youtube: $data['youtube'],
            website: $data['website'],
        );
    }
}
