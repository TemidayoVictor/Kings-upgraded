<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\DTOs\Auth\VerificationCodeDTO;
use App\Actions\Auth\VerificationCodeAction;

class VerifyEmail extends Component
{
    public string $code = '';
    protected int $user_id;
    protected array $rules = [
        'code' => 'required|string|size:6',
    ];
    public function submit() {
        $this->validate();
        $this->user_id = auth()->id();

        $buildDto = [
            'user_id' => $this->user_id,
            'code' => $this->code,
        ];

        $dto = VerificationCodeDTO::fromArray($buildDto);

        try {
            VerificationCodeAction::execute($dto);
            // Send success toast if successful
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Mail verified successfully',
                'title' => 'Success',
                'duration' => '5000',
            ]);
        } catch (\Exception $e) {
            // Send error toast if error occurs
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => $e->getMessage(),
                'title' => 'Failed!',
                'duration' => '5000',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.auth.verify-email')
            ->layout('layouts.app')
            ->title('Verify Email');
    }
}
