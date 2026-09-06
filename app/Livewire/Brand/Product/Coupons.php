<?php

namespace App\Livewire\Brand\Product;

use App\Actions\Brand\CouponAction;
use App\DTOs\Brand\CouponDTO;
use App\DTOs\GeneralDTO;
use App\Models\Coupon;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Coupons extends Component
{
    use Toastable, WithPagination;

    public ?Coupon $coupon = null;

    public string $code = '';

    public string $type = 'fixed';

    public string $value = '';

    public int $minOrderAmount = 0;

    public int $maxDiscountAmount = 0;

    public $startsAt = null;

    public $expiresAt = null;

    public int $perPage = 10;

    public ?int $selectedCouponId = null;

    protected $listeners = ['refreshCoupons' => '$refresh'];

    public function createCoupon(): void
    {
        $validated = $this->validate([
            'code' => 'required|max:6|min:6',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'startsAt' => 'required|date|date_format:Y-m-d',
            'expiresAt' => 'required|date|date_format:Y-m-d',
        ]);
        $dto = CouponDTO::fromArray($validated);
        try {
            CouponAction::execute($dto);
            $this->toast('success', 'Coupon created successfully');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }

        $this->dispatch('coupon-created');
    }

    public function editCoupon(int $couponId): void
    {
        $this->selectedCouponId = $couponId;
        $coupon = Coupon::findOrFail($couponId);

        $this->code = $coupon->code;
        $this->type = $coupon->type;
        $this->value = $coupon->value;
        $this->startsAt = $coupon->starts_at ? $coupon->starts_at->format('Y-m-d') : null;
        $this->expiresAt = $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : null;
    }

    public function updateCoupon(): void
    {
        $validated = $this->validate([
            'code' => 'required|max:6|min:6|unique:coupons,code,'.$this->selectedCouponId,
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'startsAt' => 'nullable|date|date_format:Y-m-d',
            'expiresAt' => 'nullable|date|date_format:Y-m-d|after:startsAt',
        ]);

        $validated['id'] = $this->selectedCouponId;
        $dto = CouponDTO::fromArray($validated);

        try {
            CouponAction::update($dto);
            $this->toast('success', 'Coupon updated successfully');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }

        $this->dispatch('coupon-updated');
    }

    public function confirmDeactivate(int $couponId): void
    {
        $this->selectedCouponId = $couponId;
    }

    public function deactivateCoupon(): void
    {
        $buildDto = [
            'id' => $this->selectedCouponId,
        ];
        $dto = GeneralDTO::fromArray($buildDto);
        try {
            CouponAction::deactivate($dto);
            $this->toast('success', 'Coupon deactivated successfully');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
        $this->dispatch('coupon-deactivated');
    }

    public function resetForm(): void
    {
        $this->reset(['code', 'type', 'value', 'minOrderAmount', 'maxDiscountAmount', 'startsAt', 'expiresAt', 'selectedCouponId']);
        $this->resetValidation();
    }

    public function render(): View
    {
        $coupons = Coupon::where('brand_id', auth()->user()->brand->id)
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.brand.product.coupons', [
            'coupons' => $coupons,
        ])
            ->layout('layouts.auth')
            ->title('Coupon');
    }
}
