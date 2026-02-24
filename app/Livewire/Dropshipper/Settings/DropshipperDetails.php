<?php

namespace App\Livewire\Dropshipper\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

use App\Traits\Toastable;
use App\Models\User;
use App\Actions\Dropshipper\DropshipperDetailAction;
use App\DTOs\Dropshipper\DropshipperDetailsDTO;

class DropshipperDetails extends Component
{
    use WithFileUploads;
    use Toastable;

    public $logo;
    public User $user;
    public ?int $dropshipperId = null;
    public string|null $currentLogo = '';
    public string|null $username = '';
    public string|null $bankName = '';
    public string|null $accountNumber = '';
    public string|null $accountName = '';

    protected function rules(): array
    {
        return [
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'username' => [
                'required',
                'max:255',
                'regex:/^[A-Za-z0-9_]+$/',
                Rule::unique('dropshippers', 'username')
                    ->ignore($this->dropshipperId),
            ],
            'bankName' => 'required',
            'accountNumber' => 'required',
            'accountName' => 'required',
        ];
    }

    protected $messages = [
        'username.regex' => 'Username can only contain alphanumeric characters and underscores (_).',
    ];

    public function mount(): void
    {
        $user = User::with('dropshipper')->where('id', auth()->id())->first();
        $this->user = $user;
        $this->dropshipperId = $user->dropshipper->id;
        $this->currentLogo = $user->dropshipper->image ?? 'images/profile_pic.svg';
        $this->username = $user->dropshipper->username;
        $this->bankName = $user->dropshipper->bank_name;
        $this->accountNumber = $user->dropshipper->account_number;
        $this->accountName = $user->dropshipper->account_name;
    }

    public function updatedLogo($logo): void
    {
        $this->logo = $logo;
        $this->currentLogo = '';
    }

    public function updatedUsername($value)
    {
        $value = strtolower($value);          // convert to lowercase
        $value = str_replace(' ', '_', $value); // replace spaces with underscore
        $this->username = $value;
    }

    public function submit()
    {
        $validated = $this->validate();
        $dto = DropshipperDetailsDTO::fromArray($validated);
        try {
            DropshipperDetailAction::execute($dto);
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Details updated successfully',
                'title' => 'Success',
                'duration' => 5000,
            ]);
//          redirect to dashboard
            return redirect()->route('dropshipper-dashboard');
        } catch (\Exception $e) {
            session()->flash('toast', [
                'type' => 'error',
                'message' => $e->getMessage(),
                'title' => 'Success',
                'duration' => 5000,
            ]);
            return back();
        }
    }

    public function render()
    {
        return view('livewire.dropshipper.settings.dropshipper-details')
            ->layout('layouts.auth')
            ->title('Dropshipper Details');
    }
}
