<?php

namespace App\Actions\Brand;

use App\DTOs\Brand\AdditionalDetailsDTO;
use App\DTOs\Brand\StoreSettingsDTO;
use App\Enums\UserType;
use App\Models\BrandSetting;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Storage;

class AdditionalDetailsActions
{
    /**
     * @throws Exception
     */
    public static function execute(AdditionalDetailsDTO $dto): User
    {
        $user = auth()->user();
        if (! $user || $user->role != UserType::BRAND) {
            throw new Exception('User not found.');
        }

        $brand = $user->brand;
        if (! $brand) {
            throw new Exception('Brand not found.');
        }

        $path = null;
        $image = $dto->logo;
        if (! empty($image)) {
            $path = $image->store('images', 'public');
            // logo has been updated
            if (! empty($brand->image) && Storage::disk('public')->exists($brand->image)) {
                //                delete previous logo
                Storage::disk('public')->delete($brand->image);
            }

        } elseif (! empty($brand->image)) {
            $path = $brand->image;
        }

        $brand->update([
            'image' => $path,
            'about' => $dto->about,
            'motto' => $dto->motto,
            'instagram' => self::normalizeUrl($dto->instagram),
            'facebook' => self::normalizeUrl($dto->facebook),
            'twitter' => self::normalizeUrl($dto->twitter),
            'youtube' => self::normalizeUrl($dto->youtube),
            'tiktok' => self::normalizeUrl($dto->tiktok),
            'linkedin' => self::normalizeUrl($dto->linkedin),
            'website' => self::normalizeUrl($dto->website),
        ]);

        return $user;
    }

    /**
     * @throws Exception
     */
    public static function storeSettings(StoreSettingsDTO $dto): User
    {
        $user = auth()->user();
        if (! $user || $user->role != UserType::BRAND) {
            throw new Exception('User not found.');
        }

        $brand = $user->brand;
        if (! $brand) {
            throw new Exception('Brand not found.');
        }

        BrandSetting::updateOrCreate(
            ['brand_id' => $user->brand->id],
            [
                'hero_tagline' => $dto->hero_tagline,
                'hero_title_line_1' => $dto->hero_title_line_1,
                'hero_title_line_2_italic' => $dto->hero_title_line_2_italic,
                'hero_description' => $dto->hero_description,
                'hero_button_text' => $dto->hero_button_text,
                'primary_color' => $dto->primary_color,
                'secondary_color' => $dto->secondary_color,
            ]
        );

        return $user;
    }

    private static function normalizeUrl(?string $url, ?string $platform = null): ?string
    {
        $url = trim($url ?? '');

        if ($url === '') {
            return null;
        }

        // Convert social media usernames to profile URLs.
        if ($platform && str_starts_with($url, '@')) {
            $username = ltrim($url, '@');

            $domains = [
                'instagram' => 'https://www.instagram.com/',
                'twitter' => 'https://x.com/',
                'tiktok' => 'https://www.tiktok.com/@',
            ];

            if (isset($domains[$platform])) {
                return $domains[$platform].$username;
            }
        }

        // Add HTTPS when no protocol is supplied.
        if (! preg_match('/^https?:\/\//i', $url)) {
            $url = 'https://'.$url;
        }

        return $url;
    }
}
