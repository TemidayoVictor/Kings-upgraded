<?php

namespace App\Actions\Brand;

use App\DTOs\Brand\SectionDTO;

use App\Models\Section;
use App\Models\Product;
use App\Enums\UserType;

class SectionAction
{
    public static function execute(SectionDTO $dto): Section
    {
        $user = auth()->user();

        if (!$user || $user->role != UserType::BRAND) {
            throw new \Exception('User not found.');
        }
        $brandId = auth()->user()->brand->id;

//        create section
        return Section::create([
            'brand_id' => $brandId,
            'name' => $dto->name,
        ]);
    }

    public static function edit(SectionDTO $dto): Section
    {
        $user = auth()->user();

        if (!$user || $user->role != UserType::BRAND) {
            throw new \Exception('User not found.');
        }

        $section = Section::findOrFail($dto->sectionId);
        $section->update([
            'name' => $dto->name,
        ]);

        return $section;
    }

    public static function delete(SectionDTO $dto): void
    {
        $user = auth()->user();

        if (!$user || $user->role != UserType::BRAND) {
            throw new \Exception('User not found.');
        }

        $section = Section::findOrFail($dto->sectionId);

//        edit all products using the section
        $products = Product::where('section', $section->id)->where('brand_id', auth()->user()->brand->id)->get();
        foreach ($products as $product) {
            $product->update([
                'section' => null,
            ]);
        }
//        delete section
        $section->delete();
    }
}
