<?php

namespace App\DTOs\Brand;

readonly class StoreSettingsDTO
{
    public function __construct(
        public string $hero_tagline,
        public string $hero_title_line_1,
        public string $hero_title_line_2_italic,
        public string $hero_description,
        public string $hero_button_text,
        public string $primary_color,
        public string $secondary_color,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            hero_tagline: $data['hero_tagline'],
            hero_title_line_1: $data['hero_title_line_1'],
            hero_title_line_2_italic: $data['hero_title_line_2_italic'],
            hero_description: $data['hero_description'],
            hero_button_text: $data['hero_button_text'],
            primary_color: $data['primary_color'],
            secondary_color: $data['secondary_color'],
        );
    }
}
