<?php

namespace App\Livewire\Admin;

use App\Services\Logging\LogViewerService;
use Livewire\Component;
use Livewire\WithPagination;

class Logs extends Component
{
    use WithPagination;

    public string $date = '';

    public string $search = '';

    public string $level = 'all';

    public int $perPage = 50;

    public ?array $selectedLog = null;

    public bool $showDetailsModal = false;

    public bool $showClearModal = false;

    public function mount(LogViewerService $logViewer): void
    {
        $this->date = $logViewer->availableDates()->first()
            ?? now()->format('Y-m-d');
    }

    public function updatedDate(): void
    {
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedLevel(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->level = 'all';

        $this->resetPage();
    }

    public function viewLog(array $log): void
    {
        $this->selectedLog = $log;
        $this->showDetailsModal = true;
    }

    public function closeDetails(): void
    {
        $this->selectedLog = null;
        $this->showDetailsModal = false;
    }

    public function confirmClear(): void
    {
        $this->showClearModal = true;
    }

    public function clearLog(LogViewerService $logViewer): void
    {
        $logViewer->clear($this->date);
        $this->showClearModal = false;
        $this->resetPage();
    }

    public function render(LogViewerService $logViewer)
    {
        $result = [];

        try {
            $result = $logViewer->search(
                date: $this->date,
                search: $this->search,
                level: $this->level,
                page: $this->getPage(),
                perPage: $this->perPage,
            );
        } catch (\Throwable) {
            $result = [
                'items' => collect(),
                'total' => 0,
                'current_page' => 1,
                'per_page' => $this->perPage,
                'last_page' => 1,
            ];
        }

        $fileExists = false;
        $fileSize = 0;
        $lastModified = null;

        try {
            $fileSize = $logViewer->size($this->date);
            $lastModified = $logViewer->lastModified($this->date);
            $fileExists = true;
        } catch (\Throwable) {
            //
        }

        return view('livewire.admin.logs', [
            'logs' => $result,
            'dates' => $logViewer->availableDates(),
            'fileExists' => $fileExists,
            'fileSize' => $fileSize,
            'lastModified' => $lastModified,
        ])
            ->layout('layouts.auth')
            ->title('Dashboard');
    }
}
