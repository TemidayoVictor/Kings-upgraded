<?php

namespace App\Livewire;

use App\Actions\OrderAction;
use App\Models\Wishlist;
use App\Traits\Toastable;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class ManageWishlist extends Component
{
    use Toastable;

    public Collection $wishlistItems;

    public Wishlist $selectedWishList;

    public bool $showModal = false;

    public function loadWishlist(): void
    {
        $this->wishlistItems = Wishlist::with(['product'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    public function displayModal(Wishlist $wishList): void
    {
        $this->showModal = true;
        $this->selectedWishList = $wishList;
    }

    public function removeItem(): void
    {
        try {
            OrderAction::removeWish($this->selectedWishList->id);
            $this->toast('success', 'Order batched successfully.');
        } catch (\Throwable $e) {
            $this->toast('error', $e->getMessage());
        }
    }

    public function render(): View
    {
        $this->loadWishlist();
        return view('livewire.manage-wishlist')->layout('layouts.auth')
            ->title('My Saved Wishlist');
    }
}
