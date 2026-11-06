<div>
    <main class="relative z-10 w-full min-h-screen flex items-center justify-center px-gutter-mobile lg:px-gutter py-6 lg:py-space-xl pt-safe pb-safe">
        <div class="w-full max-w-[384px] mx-auto">

            {{-- ==================== RECOVERY CARD ==================== --}}
            <div class="w-full bg-surface-container/60 backdrop-blur-md rounded-2xl p-space-lg lg:p-space-xl shadow-xl relative">

                {{-- Ambient gold bloom behind crown --}}
                <div class="absolute top-8 left-1/2 -translate-x-1/2 w-32 h-32 rounded-full bg-primary/10 blur-3xl pointer-events-none"></div>

                {{-- Heading --}}
                <div class="text-center mt-space-md">
                    <div class="flex justify-center mb-space-sm">
                        <a href="{{ route('home') }}" class="transition-transform duration-300 hover:scale-105">
                            <img src="{{ asset('images/Logo-Crown.svg') }}" alt="KING'S Crown Logo" class="w-12 h-12 object-contain filter drop-shadow-[0_2px_12px_rgba(233,163,93,0.35)]" />
                        </a>
                    </div>
                    <h1 class="font-headline-md text-headline-md lg:font-headline-lg lg:text-headline-lg text-on-surface tracking-tight font-semibold">
                        Forgot your password?
                    </h1>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-space-xs px-2 leading-relaxed">
                        Enter the email linked to your account and we'll send you a reset link.
                    </p>
                </div>

                {{-- ==================== FORM ==================== --}}
                <form wire:submit="sendResetLink" class="w-full mt-space-lg flex flex-col space-y-space-md">

                    {{-- Email input --}}
                    <div class="flex flex-col space-y-1.5 text-left w-full">
                        <label class="block font-label-md text-label-md text-on-surface-variant font-medium" for="email">
                            Email address
                        </label>
                        <div class="relative">
                            <input
                                id="email"
                                name="email"
                                type="email"
                                required
                                autocomplete="email"
                                placeholder="name@domain.com"
                                wire:model="email"
                                class="w-full h-12 pl-4 pr-4 bg-surface-container-high text-on-surface placeholder:text-outline font-body-md text-body-md rounded-xl focus:outline-none focus:ring-2 focus:ring-primary shadow-sm transition duration-200"
                            />
                        </div>
                        @error('email')
                        <div class="error-message flex items-start gap-2.5 px-3 py-2.5 rounded-lg bg-error-container/15 border border-error/25">
                                <span class="material-symbols-outlined text-[16px] text-error shrink-0 mt-px" style="font-variation-settings: 'FILL' 1;">
                                    error
                                </span>
                            <p class="text-error text-[12px] font-medium leading-relaxed tracking-wide">{{ $message }}</p>
                        </div>
                        @enderror
                    </div>

                    {{-- Success message --}}
                    @if(session()->has('message'))
                        <div class="error-message flex items-start gap-2.5 px-3 py-2.5 rounded-lg bg-emerald-500/10 border border-emerald-500/25">
                            <span class="material-symbols-outlined text-[16px] text-emerald-400 shrink-0 mt-px" style="font-variation-settings: 'FILL' 1;">
                                check_circle
                            </span>
                            <p class="text-emerald-300 text-[12px] font-medium leading-relaxed tracking-wide">{{ session('message') }}</p>
                        </div>
                    @endif

                    {{-- Submit --}}
                    <flux:button
                        type="submit"
                        variant="primary"
                        class="w-full bg-primary-container text-on-primary-container hover:bg-primary transition duration-200 focus:outline-none focus:ring-2 focus:ring-primary-fixed active:scale-[0.99] flex items-center justify-center gap-space-sm !py-3.5 !rounded-xl"
                    >
                        <span wire:loading.remove wire:target="sendResetLink" class="inline-flex items-center justify-center gap-2">
                            {{ __('Send reset link') }}
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                        </span>
                        <span wire:loading wire:target="sendResetLink" class="inline-flex items-center justify-center gap-2">
                            {{ __('Securing link…') }}
                            <span class="material-symbols-outlined text-[20px] animate-spin">progress_activity</span>
                        </span>
                    </flux:button>
                </form>

                {{-- Back to login --}}
                <div class="mt-space-lg flex items-center justify-center">
                    <a href="{{ route('login') }}" wire:navigate class="inline-flex items-center gap-2 font-label-md text-label-md text-primary hover:text-primary-fixed transition-colors duration-150 py-1.5 px-3 rounded-lg hover:bg-surface-container-high/40">
                        <span class="material-symbols-outlined text-base">arrow_back</span>
                        <span>Back to login</span>
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>
