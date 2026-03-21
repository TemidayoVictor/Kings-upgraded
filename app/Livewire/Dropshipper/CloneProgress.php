<?php

namespace App\Livewire\Dropshipper;

use App\Models\DropshipperStore;
use App\Services\StoreCloningService;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Component;

class CloneProgress extends Component
{
    use Toastable;

    public DropshipperStore $store;

    public $progress = [];

    public $pollingInterval = 3000; // 3 seconds

    protected $listeners = ['checkProgress'];

    public function mount(DropshipperStore $store): void
    {
        $this->store = $store;
        $this->checkProgress();
    }

    public function checkProgress(): void
    {
        $service = app(StoreCloningService::class);
        $this->progress = $service->getCloneProgress($this->store);

        if ($this->progress['is_complete']) {
            $this->pollingInterval = 0; // Stop polling
            $this->dispatch('clone-complete');
        }
    }

    public function render(): View
    {
        return view('livewire.dropshipper.clone-progress')
            ->layout('layouts.auth')
            ->title('Clone Progress');
    }
}
