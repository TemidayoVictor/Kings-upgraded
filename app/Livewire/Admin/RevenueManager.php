<?php

namespace App\Livewire\Admin;

use App\Enums\Status;
use App\Models\Revenue;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class RevenueManager extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filter = 'all';

    public float $totalRevenue = 0;

    public float $monthlyRevenue = 0;

    public float $todayRevenue = 0;

    public int $totalTransactions = 0;

    public int $activeSubscriptions = 0;

    public int $renewals = 0;

    public int $upgrades = 0;

    public function mount(): void
    {
        $this->loadStats();
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;

        $this->resetPage();
    }

    public function loadStats(): void
    {
        $this->totalRevenue = Revenue::sum('amount');

        $this->monthlyRevenue = Revenue::whereMonth('created_at', now()->month)
            ->sum('amount');

        $this->todayRevenue = Revenue::whereDate('created_at', today())
            ->sum('amount');

        $this->totalTransactions = Revenue::count();

        $this->activeSubscriptions = Revenue::where('subscription_status', 'active')
            ->count();

        $this->renewals = Revenue::where('description', 'like', '%renew%')
            ->count();

        $this->upgrades = Revenue::where('description', 'like', '%upgrade%')
            ->count();
    }

    public function render(): View
    {
        $revenues = Revenue::query()
            ->with(['user', 'brand'])
            ->where(function ($query) {
                $query
                    ->where('description', 'like', '%'.$this->search.'%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('name', 'like', '%'.$this->search.'%')
                            ->orWhere('email', 'like', '%'.$this->search.'%');
                    })
                    ->orWhereHas('brand', function ($q) {
                        $q->where('brand_name', 'like', '%'.$this->search.'%');
                    });
            });

        switch ($this->filter) {

            case 'today':
                $revenues->whereDate('created_at', today());
                break;

            case 'this-month':
                $revenues->whereMonth('created_at', now()->month);
                break;

            case 'renewals':
                $revenues->where('description', Status::RENEWAL);
                break;

            case 'upgrades':
                $revenues->where('description', Status::UPGRADE);
                break;
        }

        $revenues = $revenues
            ->latest()
            ->paginate(10);

        return view('livewire.admin.revenue-manager', [
            'revenues' => $revenues,
        ])
            ->layout('layouts.auth')
            ->title('Revenue Report');
    }
}
