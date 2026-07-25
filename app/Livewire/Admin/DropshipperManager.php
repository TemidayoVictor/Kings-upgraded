<?php

namespace App\Livewire\Admin;

use App\Actions\Dropshipper\SubscriptionsAction;
use App\Enums\Status;
use App\Models\Dropshipper;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class DropshipperManager extends Component
{
    use Toastable;
    use WithPagination;

    public string $search = '';

    public string $filter = 'all';

    public int $totalDropshippers = 0;

    public int $activeDropshippers = 0;

    public int $expiredDropshippers = 0;

    public bool $showModal = false;

    public string $type;

    public ?Dropshipper $selectedDropshipper;

    public int $duration;

    public function mount(): void
    {
        $this->loadDropshipperStats();
    }

    public function loadDropshipperStats(): void
    {
        $this->totalDropshippers = Dropshipper::count();
        $this->activeDropshippers = Dropshipper::active()->count();
        $this->expiredDropshippers = Dropshipper::expired()->count();
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;

        $this->resetPage();
    }

    public function openModal(int $id, string $type): void
    {
        $this->showModal = true;
        $this->type = $type;
        $this->selectedDropshipper = Dropshipper::findOrfail($id);
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->type = '';
        $this->selectedDropshipper = null;
    }

    public function deactivate(int $dropshipperId): void
    {
        if (! $dropshipperId) {
            $this->toast('error', 'Please select a dropshipper.');
        }

        try {
            $dropshipper = Dropshipper::findOrFail($dropshipperId);
            $dropshipper->update([
                'status' => Status::DEACTIVATED,
            ]);
            $this->toast('success', 'Dropshipper deactivated successfully.');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
    }

    public function activate(int $dropshipperId): void
    {
        if (! $dropshipperId) {
            $this->toast('error', 'Please select a dropshipper.');
        }

        try {
            $dropshipper = Dropshipper::findOrFail($dropshipperId);
            $dropshipper->update([
                'status' => Status::COMPLETED,
            ]);
            $this->toast('success', 'Dropshipper activated successfully.');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
    }

    public function changeSubscription(string $type, int $id): void
    {
        if ($type) {
            try {
                SubscriptionsAction::execute($type, $id);
                $this->toast('success', 'Subscription type updated successfully.!');
            } catch (\Exception $e) {
                $this->toast('error', $e->getMessage());
            }
        } else {
            $this->toast('error', 'Kindly select a valid subscription type.');
        }

        $this->closeModal();
    }

    public function renewSubscription(): void
    {
        if ($this->duration) {
            try {
                SubscriptionsAction::renew($this->duration, $this->selectedDropshipper->id);
                $this->toast('success', 'Subscription renewed successfully.!');
            } catch (\Exception $e) {
                $this->toast('error', $e->getMessage());
            }
        } else {
            $this->toast('error', 'Kindly select a duration.');
        }

        $this->closeModal();
    }

    public function render(): View
    {
        $dropshippers = Dropshipper::query()
            ->with(['user', 'stores'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('username', 'like', '%'.$this->search.'%')
                        ->orWhereHas('user', function ($userQuery) {
                            $userQuery->where('name', 'like', '%'.$this->search.'%');
                        });
                });
            });

        // Apply filter using scopes
        match ($this->filter) {
            'active' => $dropshippers->active(),
            'expired' => $dropshippers->expired(),
            'inactive' => $dropshippers->inactive(),
            default => null,
        };

        $dropshippers = $dropshippers
            ->latest()
            ->paginate(10);

        return view('livewire.admin.dropshipper-manager', [
            'dropshippers' => $dropshippers,
        ])
            ->layout('layouts.auth')
            ->title('Dropshippers List');
    }
}
