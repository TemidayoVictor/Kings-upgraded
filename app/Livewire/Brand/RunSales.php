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

    public array $tags = [];

    public string $tagInput = '';

    protected $rules = [
        'name' => 'string|required',
        'description' => 'string|nullable',
        'sale_mode' => 'string|required',
        'discount_type' => 'string|required',
        'discount_value' => 'numeric|required',
        'starts_at' => 'string|required',
        'section' => 'string|required',
        'ends_at' => 'string|required',
        'tags' => ['nullable', 'array', 'max:10'],
        'tags.*' => [
            'required',
            'string',
            'min:2',
            'max:50',
        ],
    ];

    public function mount(?Sale $sale = null): void
    {
        $this->sections = Section::where('brand_id', auth()->user()->brand->id)->get();
        if ($sale) {
            $this->selectedSale = $sale;
            $this->activeSale = null;

            // populate sale
            $this->populateFormWithSales($sale);
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
            'tags' => $this->tags,
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
                ->where('ongoing', true)
                ->orderBy('id', 'desc')
                ->first();

            if ($activeSale) {
                $this->activeSale = $activeSale;
            } else {
                $this->activeSale = null;
            }
        } else {
            $this->activeSale = null;
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
        $this->sale_mode = $sale->sale_mode;
        $this->tags = $sale->tags()
            ->pluck('name')
            ->toArray();
    }

    public function addTag(): void
    {
        $tag = trim(preg_replace('/\s+/', ' ', $this->tagInput));

        if ($tag === '') {
            return;
        }

        if (mb_strlen($tag) < 2 || mb_strlen($tag) > 50) {
            $this->addError('tagInput', 'Tags must be between 2 and 50 characters.');

            return;
        }

        if (count($this->tags) >= 10) {
            $this->addError('tags', 'You can only add up to 10 tags.');

            return;
        }

        $exists = collect($this->tags)->contains(
            fn ($existing) => mb_strtolower($existing) === mb_strtolower($tag)
        );

        if ($exists) {
            $this->addError('tagInput', 'This tag has already been added.');

            return;
        }

        $this->tags[] = $tag;

        $this->tagInput = '';

        $this->resetValidation(['tags', 'tagInput']);
    }

    public function removeTag(int $index): void
    {
        if (! isset($this->tags[$index])) {
            return;
        }

        unset($this->tags[$index]);

        $this->tags = array_values($this->tags);

        $this->resetValidation('tags');
    }

    public function render(): View
    {
        $this->checkCurrentSales();

        return view('livewire.brand.run-sales')->layout('layouts.auth')
            ->title('Run Sales');
    }
}
