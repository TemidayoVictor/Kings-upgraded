<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\DTOs\Auth\VerificationCodeDTO;
use App\Actions\Auth\VerificationCodeAction;
use App\Actions\Auth\SendVerificationCodeAction;
use App\DTOs\Auth\SendVerificationCodeDTO;
use App\Traits\Toastable;

class VerifyEmail extends Component
{
    use Toastable;
    public string $code = '';
    protected int $user_id;
    public int $resendCooldown = 120; // 2 minutes in seconds
    public bool $canResend = false;
    protected $listeners = ['countdownTick'];
    protected array $rules = [
        'code' => 'required|string|size:6',
    ];

    public function mount(): void {
        $this->startCooldown();
    }
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
//            trigger successful toast
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Email verified successfully',
                'title' => 'Success',
                'duration' => 5000,
            ]);
//            redirect
            return redirect()->route('select-role');

        } catch (\Exception $e) {
            // Send error toast if error occurs
            $this->toast('error', $e->getMessage());
        }
    }

    public function resend(){
//        if (!$this->canResend) return; // checking if user can click resend button
        $user = auth()->user();

//        Build user data
        $buildDto = [
          'id' => $user->id,
          'name' => $user->name,
          'email' => $user->email,
        ];

        $dto = SendVerificationCodeDTO::fromArray($buildDto);

//      Send verification code
        SendVerificationCodeAction::execute($dto);

//        Restart timer
        $this->startCooldown();

        $this->toast('success', 'Verification code resent');
    }

    public function startCooldown(): void
    {
        $this->canResend = false;
        $this->dispatch('start-resend-timer', ['seconds' => $this->resendCooldown]);
    }

    public function render()
    {
        return view('livewire.auth.verify-email')
            ->layout('layouts.app')
            ->title('Verify Email');
    }
}
