<?php

namespace App\Livewire\Dropshipper;

use App\Models\DropshipperEarning;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class TotalRevenueGenerated extends Component
{
    public int $dropshipperId;

    public ?string $selectedMonth = null;

    public ?string $selectedYear = null;

    public ?string $selectedMonthName = null;

    public int $selectedMonthTotal = 0;

    public ?Collection $monthlyRecords = null;

    public ?Collection $earnings = null;

    public int $perPage = 10;

    public function mount(): void
    {
        $this->dropshipperId = auth()->user()->dropshipper->id;
    }

    public function loadMonthlySummary(): void
    {
        $this->earnings = DropshipperEarning::query()
            ->whereHas('store', function ($q) {
                $q->where('dropshipper_id', $this->dropshipperId);
            })
            ->selectRaw('
                YEAR(created_at) as year,
                MONTH(created_at) as month_number,
                MONTHNAME(created_at) as month_name,
                SUM(amount) as total_amount,
                COUNT(*) as transactions_count
            ')
            ->groupByRaw('YEAR(created_at), MONTH(created_at), MONTHNAME(created_at)')
            ->orderByRaw('YEAR(created_at) DESC, MONTH(created_at) DESC')
            ->get();
    }

    public function viewMonthDetails($year, $month, $monthName): void
    {
        $this->selectedYear = $year;
        $this->selectedMonth = $month;
        $this->selectedMonthName = $monthName;

        // Get all individual records for this month
        $this->monthlyRecords = DropshipperEarning::query()
            ->whereHas('store', function ($q) {
                $q->where('dropshipper_id', $this->dropshipperId);
            })
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('created_at', 'DESC')
            ->get();

        $this->selectedMonthTotal = $this->monthlyRecords->sum('amount');
    }

    public function clearSelectedMonth(): void
    {
        $this->selectedMonth = null;
        $this->selectedYear = null;
        $this->selectedMonthName = null;
        $this->selectedMonthTotal = 0;
        $this->monthlyRecords = null;
    }

    public function render(): View
    {
        $this->loadMonthlySummary();
        $earnings = DropshipperEarning::query()
            ->whereHas('store', function ($q) {
                $q->where('dropshipper_id', $this->dropshipperId);
            })
            ->selectRaw('
                YEAR(created_at) as year,
                MONTH(created_at) as month_number,
                MONTHNAME(created_at) as month_name,
                SUM(amount) as total_amount
            ')
            ->groupByRaw('YEAR(created_at), MONTH(created_at), MONTHNAME(created_at)')
            ->orderByRaw('YEAR(created_at) DESC, MONTH(created_at) DESC')
            ->paginate($this->perPage);

        return view('livewire.dropshipper.total-revenue-generated', [
            'earnings' => $earnings,
        ])->layout('layouts.auth')->title('Revenue Generated');
    }
}
