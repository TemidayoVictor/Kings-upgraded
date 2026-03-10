<?php

namespace App\Livewire\Checkout;

use App\Models\Brand;
use App\Models\CouponUsage;
use App\Models\DeliveryLocation;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Index extends Component
{
    public $cart;

    public Brand $brand;

    public CartService $cartService;

    public $cartItems = [];

    public $subtotal = 0;

    public $tax = 0;

    public $shipping = 0;

    public $discount = 0;

    public $total = 0;

    // Customer Information
    public $customer_name = '';

    public $customer_email = '';

    public $customer_phone = '';

    // Delivery Information
    public $delivery_address = '';

    public $delivery_city = '';

    public $delivery_state = '';

    public $delivery_zip = '';

    public $delivery_instructions = '';

    public $delivery_location_id = null;

    public $delivery_locations = [];

    public $selected_location = null;

    public $delivery_price = 0;

    // Payment
    public $payment_method = 'card';

    public $customer_notes = '';

    // UI State
    public $currentStep = 1;

    public $termsAccepted = false;

    public $processing = false;

    protected $rules = [
        // Step 1: Customer Information
        'customer_name' => 'required|string|min:3|max:255',
        'customer_email' => 'required|email|max:255',
        'customer_phone' => 'required|string|max:20',

        // Step 2: Delivery Information
        'delivery_location_id' => 'required|exists:delivery_locations,id',
        'delivery_address' => 'required|string|max:255',
        'delivery_city' => 'required|string|max:100',
        'delivery_state' => 'required|string|max:100',
        'delivery_zip' => 'nullable|string|max:20',
        'delivery_instructions' => 'nullable|string|max:500',

        // Step 3: Payment
        'payment_method' => 'required|in:card,bank_transfer,cash_on_delivery',
        'termsAccepted' => 'accepted',
    ];

    protected $messages = [
        'termsAccepted.accepted' => 'You must accept the terms and conditions',
    ];

    public function mount()
    {
        $cartService = new CartService($this->brand->id);
        $this->cart = $cartService->getCart();
        $this->cart->load('items.product');

        if ($this->cart->items->count() === 0) {
            return redirect()->route('cart', ['brand' => $this->brand->slug]);
        }

        $this->cartItems = $this->cart->items;
        $this->subtotal = $this->cart->subtotal;
        $this->tax = $this->cart->tax;
        $this->shipping = $this->cart->shipping;
        $this->discount = $this->cart->discount;
        $this->total = $this->cart->total;

        // Load delivery locations
        $this->loadDeliveryLocations();

        // Pre-fill if user is logged in
        if (auth()->check()) {
            $user = auth()->user();
            $this->customer_name = $user->name;
            $this->customer_email = $user->email;
            $this->customer_phone = $user->phone ?? '';
        }

    }

    public function loadDeliveryLocations(): void
    {
        $this->delivery_locations = DeliveryLocation::with('children')
            ->where('brand_id', $this->cart->brand_id)
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function selectDeliveryLocation($locationId): void
    {
        $location = DeliveryLocation::find($locationId);

        if (! $location) {
            return;
        }

        $this->delivery_location_id = $locationId;
        $this->selected_location = $location;
        $this->delivery_price = $location->effective_price;

        // Update cart shipping
        $cartService = new CartService($this->brand->id);
        $setShipping = $cartService->setShipping($this->delivery_price);

        // Refresh totals
        $this->cart = $cartService->getCart();
        $this->shipping = $this->cart->shipping;
        $this->total = $this->cart->total;
    }

    public function nextStep(): void
    {
        if ($this->currentStep === 1) {
            $this->validate([
                'customer_name' => 'required|string|min:3|max:255',
                'customer_email' => 'required|email|max:255',
                'customer_phone' => 'required|string|max:20',
            ]);
        } elseif ($this->currentStep === 2) {
            $this->validate([
                'delivery_location_id' => 'required|exists:delivery_locations,id',
                'delivery_address' => 'required|string|max:255',
                'delivery_city' => 'required|string|max:100',
                'delivery_state' => 'required|string|max:100',
            ]);
        }

        $this->currentStep++;
    }

    public function previousStep(): void
    {
        $this->currentStep--;
    }

    public function placeOrder()
    {
        $this->validate();

        $this->processing = true;

        try {
            DB::beginTransaction();

            // Get cart
            $cart = app(CartService::class)->getCart();

            // Check stock again
            foreach ($cart->items as $item) {
                if ($item->product->stock_quantity < $item->quantity) {
                    throw new \Exception("Insufficient stock for {$item->product_name}");
                }
            }

            // Generate unique order number
            $orderNumber = 'ORD-'.strtoupper(uniqid());

            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => auth()->id(),
                'brand_id' => $cart->brand_id,
                'delivery_location_id' => $this->delivery_location_id,

                // Customer Information
                'customer_name' => $this->customer_name,
                'customer_email' => $this->customer_email,
                'customer_phone' => $this->customer_phone,

                // Delivery Information
                'delivery_address' => $this->delivery_address,
                'delivery_city' => $this->delivery_city,
                'delivery_state' => $this->delivery_state,
                'delivery_zip' => $this->delivery_zip,
                'delivery_instructions' => $this->delivery_instructions,

                // Pricing
                'subtotal' => $cart->subtotal,
                'tax' => $cart->tax,
                'shipping' => $cart->shipping,
                'discount' => $cart->discount,
                'total' => $cart->total,

                // Payment
                'payment_method' => $this->payment_method,
                'payment_status' => 'pending',
                'status' => 'pending',
                'customer_notes' => $this->customer_notes,

                // Coupon
                'coupon_code' => $cart->coupon_code,
                'coupon_data' => $cart->coupon_data,
            ]);

            // Create order items
            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'sku' => $item->sku,
                    'unit_price' => $item->unit_price,
                    'discount_price' => $item->discount_price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                    'total' => $item->total,
                    'options' => $item->options,
                ]);

                // Reduce stock
                $item->product->decrement('stock_quantity', $item->quantity);
            }

            // Record coupon usage if applied
            if ($cart->coupon_code && $cart->coupon_data) {
                CouponUsage::create([
                    'coupon_id' => $cart->coupon_data['id'],
                    'user_id' => auth()->id(),
                    'order_id' => $order->id,
                    'discount_amount' => $cart->discount,
                ]);

                // Increment coupon usage count
                \App\Models\Coupon::where('id', $cart->coupon_data['id'])
                    ->increment('used_count');
            }

            // Create status history
            $order->statusHistory()->create([
                'old_status' => null,
                'new_status' => 'pending',
                'changed_by' => auth()->id(),
            ]);

            // Clear the cart
            app(CartService::class)->clearCart();

            DB::commit();

            // Redirect to success page
            return redirect()->route('checkout.success', ['order' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->processing = false;

            Log::error('Order placement failed: '.$e->getMessage());

            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to place order: '.$e->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.checkout.index')->layout('layouts.shop', [
            'brand' => $this->brand,
        ]);
    }
}
