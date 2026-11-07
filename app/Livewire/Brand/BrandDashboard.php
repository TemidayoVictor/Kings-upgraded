<?php

namespace App\Livewire\Brand;

use App\Services\RevenueAnalyticsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Component;

class BrandDashboard extends Component
{
    public int $brandId;

    public string $dateRange = '30days';

    public string $startDate;

    public string $endDate;

    public array $dashboardData = [];

    public function mount($brandId = null): void
    {
        $this->brandId = $brandId ?? auth()->user()->brand->id;
        $this->updatedDateRange();
    }

    public function updatedDateRange(): void
    {
        Log::info($this->dateRange);
        switch ($this->dateRange) {
            case 'today':
                $this->startDate = Carbon::today();
                $this->endDate = Carbon::now();
                break;
            case 'yesterday':
                $this->startDate = Carbon::yesterday();
                $this->endDate = Carbon::yesterday()->endOfDay();
                break;
            case '7days':
                $this->startDate = Carbon::now()->subDays(7);
                $this->endDate = Carbon::now();
                break;
            case '30days':
                $this->startDate = Carbon::now()->subDays(30);
                $this->endDate = Carbon::now();
                break;
            case 'this_month':
                $this->startDate = Carbon::now()->startOfMonth();
                $this->endDate = Carbon::now();
                break;
            case 'last_month':
                $this->startDate = Carbon::now()->subMonth()->startOfMonth();
                $this->endDate = Carbon::now()->subMonth()->endOfMonth();
                break;
            case 'this_year':
                $this->startDate = Carbon::now()->startOfYear();
                $this->endDate = Carbon::now();
                break;
            case 'custom':
                return;
        }

        $this->loadData();
    }

    public function applyDateRange(): void
    {
        $this->validate([
            'startDate' => ['required', 'date'],
            'endDate' => ['required', 'date', 'after_or_equal:startDate'],
        ]);

        $this->loadData();
    }

    public function setCustomRange($startDate, $endDate): void
    {
        $this->startDate = Carbon::parse($startDate);
        $this->endDate = Carbon::parse($endDate);
        $this->dateRange = 'custom';
        $this->loadData();
    }

    public function loadData(): void
    {
        $this->dashboardData = RevenueAnalyticsService::getDashboardData(
            $this->brandId,
            [
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
            ]
        );

        $this->dispatch(
            'dataLoaded',
            dailyData: $this->dashboardData['daily_breakdown'] ?? []
        );
    }

    public function render(): View
    {
        return view('livewire.brand.brand-dashboard', [
            'realTimeMetrics' => RevenueAnalyticsService::getRealTimeMetrics($this->brandId),
        ])
            ->layout('layouts.auth')
            ->title('Brandowner Dashboard');
    }
}
