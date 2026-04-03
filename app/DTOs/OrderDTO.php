<?php

namespace App\DTOs;

use App\Models\Cart;
use App\Models\CartItem;
readonly class OrderDTO
{
    public function __construct(
        public Cart $cart,
        public string $customerName,
        public string $customerPhone,
        public string $customerEmail,
        public string $deliveryAddress,
        public string $deliveryCity,
        public string $deliveryState,
        public ?string $deliveryZipCode,
        public ?string $deliveryInstructions,
        public ?string $paymentMethod,
        public ?string $notes,
        public ?int $dropshipperId,
        public ?string $type,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            cart: $data['cart'],
            customerName: $data['customerName'],
            customerPhone: $data['customerPhone'],
            customerEmail: $data['customerEmail'],
            deliveryAddress: $data['deliveryAddress'],
            deliveryCity: $data['deliveryCity'],
            deliveryState: $data['deliveryState'],
            deliveryZipCode: $data['deliveryZipCode'] ?? null,
            deliveryInstructions: $data['deliveryInstructions'] ?? null,
            paymentMethod: $data['paymentMethod'] ?? null,
            notes: $data['notes'] ?? null,
            dropshipperId: $data['dropshipperId'] ?? null,
            type: $data['type'] ?? null,
        );
    }
}
