<?php

namespace App\Livewire\Brand;

use App\Actions\Brand\SalesAction;
use App\DTOs\Brand\SalesDTO;
use App\DTOs\GeneralDTO;
use App\Models\Sale;
use App\Models\Section;
use App\Traits\Toastable;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class RunSales extends Component
{
    use Toastable;

    public ?int $id = null;

    public string $name = '';

    public string $description = '';

    public string $discount_type = 'percentage';

    public int $discount_value = 0;

    public string $starts_at = '';

    public string $ends_at = '';

    public Collection $sections;

    public string $section = '0';

    public ?Sale $activeSale = null;

    public ?Sale $selectedSale = null;

    public string $sale_mode = 'generic';

    protected $rules = [
        'name' => 'string|required',
        'description' => 'string|nullable',
        'sale_mode' => 'string|required',
        'discount_type' => 'string|required',
        'discount_value' => 'numeric|required',
        'starts_at' => 'string|required',
        'section' => 'string|required',
        'ends_at' => 'string|required',
    ];

    public function mount(?Sale $sale = null): void
    {
        $this->sections = Section::where('brand_id', auth()->user()->brand->id)->get();
        if ($sale) {
            $this->selectedSale = $sale;
            $this->activeSale = null;
        } else {
            $this->selectedSale = null;
        }
    }

    public function createSale(): mixed
    {
        $this->validate();

        $buildDto = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'saleMode' => $this->sale_mode,
            'discountType' => $this->discount_type,
            'discountValue' => $this->discount_value,
            'startsAt' => $this->starts_at,
            'section' => $this->section,
            'endsAt' => $this->ends_at,
        ];

        $dto = SalesDTO::fromArray($buildDto);

        try {
            SalesAction::execute($dto);
            session()->flash('toast', [
                'type' => 'success',
                'message' => $this->activeSale || $this->selectedSale ? 'Sale updated successfully' : 'Sale created successfully',
                'title' => 'Success',
                'duration' => 5000,
            ]);

            return redirect()->route('brand-manage-sales');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());

            return back();
        }
    }

    public function toggleSaleStatus(): mixed
    {
        $buildDto = [
            'id' => $this->activeSale ? $this->activeSale->id : $this->selectedSale->id,
        ];

        $dto = GeneralDTO::fromArray($buildDto);

        try {
            SalesAction::toggle($dto);
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Sales status updated successfully',
                'title' => 'Success',
                'duration' => 5000,
            ]);

            return redirect()->route('brand-manage-sales');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
            return back();
        }
    }

    private function checkCurrentSales(): void
    {
        if (! $this->selectedSale) {
            $this->selectedSale = null;
            $activeSale = Sale::where('brand_id', auth()->user()->brand->id)
                ->where('is_active', true)
                ->orderBy('id', 'desc')
                ->first();

            if ($activeSale) {
                $this->activeSale = $activeSale;
            } else {
                $this->activeSale = null;
            }
        } else {
            $this->activeSale = null;
            $this->populateFormWithSales($this->selectedSale);
        }
    }

    public function endSales(): mixed
    {
        $buildDto = [
            'id' => $this->selectedSale->id,
        ];

        $dto = GeneralDTO::fromArray($buildDto);

        try {
            SalesAction::endSale($dto);
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Sales ended successfully',
                'title' => 'Success',
                'duration' => 5000,
            ]);
            return redirect()->route('brand-manage-sales');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
        return back();
    }

    private function populateFormWithSales(Sale $sale): void
    {
        $this->id = $sale->id;
        $this->name = $sale->name;
        $this->description = $sale->description ?? '';
        $this->discount_type = $sale->discount_type;
        $this->discount_value = $sale->discount_value;
        $this->starts_at = $sale->starts_at->format('Y-m-d\TH:i');
        $this->ends_at = $sale->ends_at->format('Y-m-d\TH:i');
    }

    public function render(): View
    {
        $this->checkCurrentSales();

        return view('livewire.brand.run-sales')->layout('layouts.auth')
            ->title('Run Sales');
    }
}
