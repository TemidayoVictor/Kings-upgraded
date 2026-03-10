<?php

namespace App\Livewire\Cart;

use App\Models\Brand;
use App\Services\CartService;
use Livewire\Component;

class Index extends Component
{
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
    public function mount()
    {
        // If we get here, the brand exists (Laravel would have thrown 404 if not)
        $this->loadCart();
    }

    public function loadCart()
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

            $this->dispatch('cartUpdated');
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Cart updated successfully',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function removeItem($itemId): void
    {
        try {
            $cartService = new CartService($this->brand->id);
            $cartService->removeItem($itemId);

            $this->dispatch('cartUpdated');
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Item removed from cart',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
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
                $this->dispatch('cartUpdated');
                $this->dispatch('notify', [
                    'type' => 'success',
                    'message' => $result['message'],
                ]);
            } else {
                $this->couponError = $result['message'];
                $this->couponMessage = '';
            }
        } catch (\Exception $e) {
            $this->couponError = $e->getMessage();
        }
    }

    public function removeCoupon()
    {
        $cartService = new CartService($this->brand->id);
        $cartService->removeCoupon();

        $this->couponCode = '';
        $this->couponMessage = '';
        $this->couponError = '';
        $this->dispatch('cartUpdated');
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Coupon removed',
        ]);
    }

    public function proceedToCheckout()
    {
        if ($this->itemCount === 0) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Your cart is empty',
            ]);
            return;
        }

        // Pass brand to checkout
        return redirect()->route('checkout', ['brand' => $this->brand->slug]);
    }

    public function render()
    {
        return view('livewire.cart.index')->layout('layouts.shop', [
            'brand' => $this->brand,
        ]);
    }
}
