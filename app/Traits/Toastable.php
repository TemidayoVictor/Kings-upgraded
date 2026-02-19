<?php

namespace App\Traits;
use Livewire\Component;

/**
 * @mixin Component
 */

trait Toastable
{
    public function toast($type, $message, $title = null): void
    {
        $this->dispatch('notify', [
            'type' => $type,
            'title' => $title ?? $type,
            'message' => $message,
        ]);
    }
}
