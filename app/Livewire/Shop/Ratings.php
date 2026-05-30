<?php

namespace App\Livewire\Shop;

use App\Actions\RatingAction;
use App\DTOs\GeneralDTO;
use App\Models\Brand;
use App\Models\Rating;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Component;

class Ratings extends Component
{
    use Toastable;

    public Brand $brand;

    public $rating = 5; // default scale

    public $review = '';

    public $hasReviewed = false;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'nullable|string|max:1000',
    ];

    public function mount(Brand $brand): void
    {
        $this->brand = $brand;

        if (auth()->check()) {
            // Locate an existing submission for this brand/user tracking pairing
            $existingReview = Rating::where('brand_id', $this->brand->id)
                ->where('user_id', auth()->id())
                ->first();

            if ($existingReview) {
                $this->rating = $existingReview->rating;
                $this->review = $existingReview->review;
                $this->hasReviewed = true;
            }
        }
    }

    public function saveReview(): void
    {
        $this->validate();

        $buildDTO = [
            'id' => 1,
            'value' => [
                'brand_id' => $this->brand->id,
                'rating' => $this->rating,
                'review' => $this->review,
            ],
        ];

        $dto = GeneralDTO::fromArray($buildDTO);
        try {
            RatingAction::execute($dto);
            $this->hasReviewed = true;
            $this->toast('success', 'Rating submitted successfully!');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.shop.ratings', [
            'reviews' => $this->brand->ratings()->with('user')->latest()->get(),
            'avgRating' => $this->brand->ratings()->avg('rating') ?? 0,
        ])->layout('layouts.shop', [
            'brand' => $this->brand,
        ])->title('Reviews');
    }
}
