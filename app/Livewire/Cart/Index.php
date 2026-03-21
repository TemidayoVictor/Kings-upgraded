<?php

namespace App\Livewire\Cart;

use App\Models\Brand;
use App\Services\CartService;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
class Index extends Component
{
    use Toastable;

    // Let Laravel automatically resolve the brand via route model binding
    public Brand $brand;

    public $cart;

    public $cartItems = [];

    public $subtotal = 0;

    public $tax = 0;

    public $shipping = 0;

    public $discount = 0;

    public $total = 0;

    public $itemCount = 0;

    public $couponCode = '';

    public $couponMessage = '';

    public $couponError = '';

    protected $listeners = [
        'cartUpdated' => 'loadCart',
        'itemRemoved' => 'loadCart',
    ];

    // No need for mount() with slug parameter - Laravel handles it
    public function mount(): void
    {
        // If we get here, the brand exists (Laravel would have thrown 404 if not)
        $this->loadCart();
    }

    public function loadCart(): void
    {
        // Create CartService with the brand ID from the resolved model
        $cartService = new CartService($this->brand->id);

        $this->cart = $cartService->getCart();
        $this->cart->load('items.product');

        $this->cartItems = $this->cart->items;
        $this->subtotal = $this->cart->subtotal;
        $this->tax = $this->cart->tax;
        $this->shipping = $this->cart->shipping;
        $this->discount = $this->cart->discount;
        $this->total = $this->cart->total;
        $this->itemCount = $this->cart->items->sum('quantity');
        $this->couponCode = $this->cart->coupon_code ?? '';
    }

    public function increment($itemId): void
    {
        $item = $this->cartItems->firstWhere('id', $itemId);
        Log::info($item->quantity);
        $this->updateQuantity($itemId, $item->quantity + 1);
        Log::info($item->quantity);
    }

    public function decrement($itemId): void
    {
        $item = $this->cartItems->firstWhere('id', $itemId);
        if ($item->quantity <= 1) {
            $this->removeItem($itemId);
            return;
        }
        $this->updateQuantity($itemId, $item->quantity - 1);
    }

    // Update all methods to use the brand from the component
    public function updateQuantity($itemId, $quantity): void
    {
        if ($quantity < 1) {
            $this->removeItem($itemId);

            return;
        }
        try {
            $cartService = new CartService($this->brand->id);
            $cartService->updateItem($itemId, $quantity);
            $this->loadCart();
            $this->toast('success', 'Cart updated successfully');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
    }

    public function removeItem($itemId): void
    {
        try {
            $cartService = new CartService($this->brand->id);
            $cartService->removeItem($itemId);
            $this->loadCart();
            $this->toast('success', 'Item removed from cart');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
    }

    public function applyCoupon(): void
    {
        if (! $this->couponCode) {
            $this->couponError = 'Please enter a coupon code';

            return;
        }

        try {
            $cartService = new CartService($this->brand->id);
            $result = $cartService->applyCoupon($this->couponCode);

            if ($result['success']) {
                $this->couponMessage = $result['message'];
                $this->couponError = '';
                $this->loadCart();
                $this->toast('success', 'Coupon applied successfully');
            } else {
                $this->couponError = $result['message'];
                $this->couponMessage = '';
            }
        } catch (\Exception $e) {
            $this->couponError = $e->getMessage();
        }
    }

    public function removeCoupon(): void
    {
        $cartService = new CartService($this->brand->id);
        $cartService->removeCoupon();

        $this->couponCode = '';
        $this->couponMessage = '';
        $this->couponError = '';
        $this->loadCart();
        $this->toast('success', 'Coupon removed');
    }

    public function proceedToCheckout(): mixed
    {
        if ($this->itemCount === 0) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Your cart is empty',
            ]);

            return back();
        }

        // Pass brand to check out
        return redirect()->route('checkout', ['brand' => $this->brand->slug]);
    }

    public function render(): View
    {
        return view('livewire.cart.index')->layout('layouts.shop', [
            'brand' => $this->brand,
        ]);
    }
}
