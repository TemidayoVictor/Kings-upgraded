<?php

namespace App\Livewire\Checkout;

use App\Actions\OrderAction;
use App\DTOs\OrderDTO;
use App\Enums\UserType;
use App\Models\DeliveryLocation;
use App\Models\DropshipperStore;
use App\Models\State;
use App\Services\DropshipperCartService;
use App\Traits\Toastable;
use Livewire\Component;

class DropshipperCheckout extends Component
{
    use Toastable;

    public $cart;

    public DropshipperStore $store;

    public DropshipperCartService $cartService;

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

    public $selected_child_parent_id = null;

    public array $states = [];

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
        $cartService = new DropshipperCartService($this->store->id, $this->store->brand->stock_alert);
        $this->cart = $cartService->getCart();
        $this->cart->load('items.dropshipperProduct.originalProduct');

        if ($this->cart->items->count() === 0) {
            return redirect()->route('dropshipper-cart', ['store' => $this->store->slug]);
        }

        $this->cartItems = $this->cart->items;
        $this->subtotal = $this->cart->subtotal;
        $this->tax = $this->cart->tax;
        $this->shipping = $this->cart->shipping;
        $this->delivery_location_id = $this->cart->delivery_location_id;
        $this->discount = $this->cart->discount;
        $this->total = $this->cart->total;

        // Load delivery locations
        $this->loadDeliveryLocations();
        $this->states = State::pluck('name', 'id')->toArray();

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
            ->where('brand_id', $this->store->brand->id)
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

        $selectedLocation = DeliveryLocation::find($locationId);
        if ($selectedLocation && $selectedLocation->parent_id) {
            $this->selected_child_parent_id = $selectedLocation->parent_id;
        } else {
            $this->selected_child_parent_id = null;
        }

        $this->delivery_location_id = $locationId;
        $this->selected_location = $location;
        $this->delivery_price = $location->effective_price;

        // Update cart shipping
        $cartService = new DropshipperCartService($this->store->id, $this->store->brand->stock_alert);
        $cartService->setShipping($this->delivery_price, $locationId);

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

    public function isParentOfSelectedChild($parentId): bool
    {
        return $this->selected_child_parent_id == $parentId;
    }

    public function placeOrder(): mixed
    {
        $this->validate();
        $this->processing = true;

        $buildDto = [
            'cart' => $this->cart,
            'customerName' => $this->customer_name,
            'customerPhone' => $this->customer_phone,
            'customerEmail' => $this->customer_email,
            'deliveryAddress' => $this->delivery_address,
            'deliveryCity' => $this->delivery_city,
            'deliveryState' => $this->delivery_state,
            'deliveryZipCode' => $this->delivery_zip,
            'deliveryInstructions' => $this->delivery_instructions,
            'paymentMethod' => $this->payment_method,
            'notes' => $this->customer_notes,
            'type' => UserType::DROPSHIPPER,
            'dropshipperId' => $this->store->dropshipper_id,
        ];

        $dto = OrderDTO::fromArray($buildDto);
        try {
            $order = OrderAction::execute($dto);

            // Trigger success toast if successful. Using session to retain toast when redirect happens
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Order placed successfully',
                'title' => 'Success',
                'duration' => 5000,
            ]);

            // redirect to success page
            return redirect()->route('checkout.success', ['order' => $order]);
        } catch (\Exception $e) {
            $this->processing = false;
            $this->toast('error', $e->getMessage());

            return back();
        }
    }

    public function render()
    {
        return view('livewire.checkout.dropshipper-checkout')->layout('layouts.store', [
            'store' => $this->store,
        ])->title('Checkout');
    }
}
