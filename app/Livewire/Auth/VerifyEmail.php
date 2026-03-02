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
    protected array $rules = [
        'code' => 'required|string|size:6',
    ];

    public function submit() {
        $this->validate();

        $buildDto = [
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
        try{
            SendVerificationCodeAction::execute();
            $this->toast('success', 'Verification code resent');
        } catch (\Exception $e) {
            // Send error toast if error occurs
            $this->toast('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.auth.verify-email')
            ->layout('layouts.app')
            ->title('Verify Email');
    }
}
