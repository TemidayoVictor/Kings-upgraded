<div class="flex min-h-screen">
    <div class="flex-1 flex justify-center items-center">
        <div class="w-80 max-w-80 space-y-6">
            <div class="flex justify-center">
                <a href="/" class="group flex items-center gap-3">
                    <img src="{{ asset('images/Logo-Crown.svg') }}" alt="Logo" class="w-12 h-12">
                </a>
            </div>

            <x-auth-header :title="__('Verify Email')" :description="__('Enter the 6-digit code sent to your email')" />

            <form wire:submit.prevent="submit" id="otp-form" class="flex flex-col gap-6 items-center">
                <div class="flex gap-3" id="otp-container">
                    <!-- 6 input boxes -->
                    @for ($i = 0; $i < 6; $i++)
                        <input
                            type="text"
                            maxlength="1"
                            inputmode="numeric"
                            pattern="[0-9]*"
                            class="w-12 h-12 text-center text-xl border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            data-index="{{ $i }}"
                        >
                    @endfor
                </div>

                <input type="hidden" name="code" id="otp-hidden" wire:model="code">

                <flux:button
                    type="submit"
                    variant="primary"
                    class="w-48 mt-4"
                    id="otp-submit"
                    disabled
                >
                    <flux:icon.loading wire:loading wire:target="submit" />
                    <span wire:loading.remove wire:target="submit">{{ __('Verify') }}</span>
                </flux:button>
            </form>

            <flux:subheading class="text-center">
                Didn't receive code? Resend in
                <span id="countdown">02:00</span>
                <flux:link id="resend-btn" wire:click="resend" href="javascript:void(0)" style="display:none;">Resend</flux:link>
            </flux:subheading>
        </div>
    </div>
</div>

{{-- Script --}}
@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('#otp-container input');
            const hiddenInput = document.getElementById('otp-hidden');
            const submitBtn = document.getElementById('otp-submit');

            const countdownEl = document.getElementById('countdown');
            const resendBtn = document.getElementById('resend-btn');
            let totalSeconds = 120; // 2 minutes

            // Auto-advance and backspace handling
            inputs.forEach((input, index) => {
                input.addEventListener('input', e => {
                    input.value = input.value.replace(/[^0-9]/g, ''); // Only digits
                    updateHidden();
                    updateSubmitState();

                    if (input.value && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', e => {
                    if (e.key === 'Backspace' && !input.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                input.addEventListener('paste', e => {
                    e.preventDefault();
                    const paste = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
                    for (let i = 0; i < inputs.length; i++) {
                        inputs[i].value = paste[i] || '';
                    }
                    updateHidden();
                    updateSubmitState();

                    // Focus the first empty input
                    const firstEmpty = Array.from(inputs).findIndex(i => i.value === '');
                    if (firstEmpty !== -1) inputs[firstEmpty].focus();
                });
            });

            function updateHidden() {
                const code = Array.from(inputs).map(i => i.value).join('');
                hiddenInput.value = code;

                // Dispatch input event so Livewire updates property
                hiddenInput.dispatchEvent(new Event('input'));
            }

            function updateSubmitState() {
                submitBtn.disabled = Array.from(inputs).some(i => i.value === '');
            }

            // Auto-focus first input on load
            inputs[0].focus();

            function startCountdown(seconds) {
                totalSeconds = seconds;
                resendBtn.style.display = 'none'; // hide resend button

                const interval = setInterval(() => {
                    const min = Math.floor(totalSeconds / 60).toString().padStart(2, '0');
                    const sec = (totalSeconds % 60).toString().padStart(2, '0');
                    countdownEl.textContent = `${min}:${sec}`;

                    if (totalSeconds <= 0) {
                        clearInterval(interval);
                        countdownEl.style.display = 'none';
                        resendBtn.style.display = 'inline'; // show resend
                    }

                    totalSeconds--;
                }, 1000);
            }

            resendBtn.addEventListener('click', () => {
                // Reload the page after 4 seconds
                setTimeout(() => {
                    window.location.reload();
                }, 4000); // 4000 milliseconds = 4 seconds
            });


            // Start countdown on page load
            startCountdown(totalSeconds);
        });

    </script>

@endpush
