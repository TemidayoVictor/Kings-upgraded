<?php

namespace App\Livewire\Cart;

use App\Actions\CartAction;
use App\DTOs\CartDTO;
use App\Enums\UserType;
use App\Models\DropshipperStore;
use App\Services\DropshipperCartService;
use App\Traits\Toastable;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Component;

class DropshipperCart extends Component
{
    use Toastable;

    // Let Laravel automatically resolve the brand via route model binding
    public DropshipperStore $store;

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
        $cartService = new DropshipperCartService($this->store->id, $this->store->brand->stock_alert);

        $this->cart = $cartService->getCart();
        $this->cart->load('items.dropshipperProduct.originalProduct');

        $this->cartItems = $this->cart->items;
        $this->subtotal = $this->cart->subtotal;
        $this->tax = $this->cart->tax;
        $this->shipping = $this->cart->shipping;
        $this->discount = $this->cart->discount;
        $this->total = $this->cart->total;
        $this->itemCount = $this->cart->items->sum('quantity');
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
        $buildDto = [
            'productId' => $itemId,
            'storeId' => $this->store->id,
            'quantity' => $quantity,
            'stockAlert' => $this->store->brand->stock_alert,
            'type' => UserType::DROPSHIPPER,
        ];

        $dto = CartDTO::fromArray($buildDto);
        if ($quantity < 1) {
            $this->removeItem($itemId);

            return;
        }
        try {
            CartAction::updateQuantity($dto);
            $this->loadCart();
            $this->toast('success', 'Cart updated successfully');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
    }

    public function removeItem($itemId): void
    {
        $buildDto = [
            'productId' => $itemId,
            'storeId' => $this->store->id,
            'stockAlert' => $this->store->brand->stock_alert,
            'type' => UserType::DROPSHIPPER,
        ];
        $dto = CartDTO::fromArray($buildDto);
        try {
            CartAction::removeItem($dto);
            $this->loadCart();
            $this->toast('success', 'Item removed from cart');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
    }
    public function proceedToCheckout(): mixed
    {
        if ($this->itemCount === 0) {
            $this->toast('error', 'Your cart is empty');
            return back();
        }

        // Pass to check out
        return redirect()->route('dropshipper-checkout', ['store' => $this->store]);
    }

    public function render(): View
    {
        return view('livewire.cart.dropshipper-cart')->layout('layouts.store', [
            'store' => $this->store,
        ])->title('Cart');
    }
}
