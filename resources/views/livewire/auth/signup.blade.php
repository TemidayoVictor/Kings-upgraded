<div>
    <main class="relative z-10 w-full min-h-screen flex items-center justify-center px-gutter-mobile lg:px-gutter py-6 lg:py-space-xl pt-safe pb-safe">
        <div class="w-full max-w-[384px] mx-auto">

            {{-- ==================== FORM CARD ==================== --}}
            <div class="w-full bg-surface-container/60 backdrop-blur-md rounded-2xl p-space-lg lg:p-space-xl shadow-xl relative">

                <div>
                    <div class="flex justify-center mb-space-sm">
                        <a href="{{ route('home') }}" class="transition-transform duration-300 hover:scale-105">
                            <img src="{{ asset('images/Logo-Crown.svg') }}" alt="KING'S Crown Logo" class="w-12 h-12 object-contain filter drop-shadow-[0_2px_12px_rgba(233,163,93,0.35)]" />
                        </a>
                    </div>
                    <div class="text-center mb-space-lg">
                        <h1 class="font-headline-lg text-headline-lg tracking-tight text-on-surface mb-space-xs font-semibold">
                            Create an account
                        </h1>
                        <p class="font-label-sm text-label-sm tracking-[0.16em] uppercase text-outline">
                            Welcome to KING'S
                        </p>
                    </div>
                </div>

                {{-- ==================== FORM ==================== --}}
                <form wire:submit="submit" class="space-y-space-md">

                    {{-- Full name --}}
                    <div class="space-y-space-xs">
                        <label class="block font-label-md text-label-md text-on-surface-variant font-medium" for="name">
                            Full name
                        </label>
                        <div class="relative">
                            <input
                                id="name"
                                name="name"
                                type="text"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="e.g. Olawale Adeleke"
                                wire:model.defer="name"
                                value="{{ old('name') }}"
                                class="w-full bg-surface-container-high text-on-surface placeholder:text-outline font-body-md text-body-md rounded-xl px-space-md py-3 focus:outline-none focus:ring-2 focus:ring-primary shadow-sm transition duration-200"
                            />
                        </div>
                        @error('name')
                        <div class="error-message flex items-start gap-2.5 px-3 py-2.5 rounded-lg bg-error-container/15 border border-error/25">
                                <span class="material-symbols-outlined text-[16px] text-error shrink-0 mt-px" style="font-variation-settings: 'FILL' 1;">
                                    error
                                </span>
                            <p class="text-error text-[12px] font-medium leading-relaxed tracking-wide">{{ $message }}</p>
                        </div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="space-y-space-xs">
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
                                wire:model.defer="email"
                                value="{{ old('email') }}"
                                class="w-full bg-surface-container-high text-on-surface placeholder:text-outline font-body-md text-body-md rounded-xl px-space-md py-3 focus:outline-none focus:ring-2 focus:ring-primary shadow-sm transition duration-200"
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

                    {{-- Password --}}
                    <div class="space-y-space-xs" x-data="{ showPw: false }">
                        <label class="block font-label-md text-label-md text-on-surface-variant font-medium" for="password">
                            Password
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                x-bind:type="showPw ? 'text' : 'password'"
                                type="password"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••••••"
                                wire:model.defer="password"
                                class="w-full bg-surface-container-high text-on-surface placeholder:text-outline font-body-md text-body-md rounded-xl px-space-md pr-11 py-3 focus:outline-none focus:ring-2 focus:ring-primary shadow-sm transition duration-200"
                            />
                            <button
                                type="button"
                                @click="showPw = !showPw"
                                aria-label="Toggle password visibility"
                                class="absolute right-space-sm top-3 text-outline hover:text-primary transition p-1 flex items-center justify-center"
                            >
                                <span class="material-symbols-outlined text-[20px]" x-text="showPw ? 'visibility_off' : 'visibility'">visibility</span>
                            </button>
                        </div>
                        @error('password')
                        <div class="error-message flex items-start gap-2.5 px-3 py-2.5 rounded-lg bg-error-container/15 border border-error/25">
                                <span class="material-symbols-outlined text-[16px] text-error shrink-0 mt-px" style="font-variation-settings: 'FILL' 1;">
                                    error
                                </span>
                            <p class="text-error text-[12px] font-medium leading-relaxed tracking-wide">{{ $message }}</p>
                        </div>
                        @enderror
                    </div>

                    {{-- Confirm password --}}
                    <div class="space-y-space-xs" x-data="{ showPw2: false }">
                        <label class="block font-label-md text-label-md text-on-surface-variant font-medium" for="password_confirmation">
                            Confirm password
                        </label>
                        <div class="relative">
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                x-bind:type="showPw2 ? 'text' : 'password'"
                                type="password"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••••••"
                                wire:model.defer="password_confirmation"
                                class="w-full bg-surface-container-high text-on-surface placeholder:text-outline font-body-md text-body-md rounded-xl px-space-md pr-11 py-3 focus:outline-none focus:ring-2 focus:ring-primary shadow-sm transition duration-200"
                            />
                            <button
                                type="button"
                                @click="showPw2 = !showPw2"
                                aria-label="Toggle confirm password visibility"
                                class="absolute right-space-sm top-3 text-outline hover:text-primary transition p-1 flex items-center justify-center"
                            >
                                <span class="material-symbols-outlined text-[20px]" x-text="showPw2 ? 'visibility_off' : 'visibility'">visibility</span>
                            </button>
                        </div>
                        @error('password_confirmation')
                        <div class="error-message flex items-start gap-2.5 px-3 py-2.5 rounded-lg bg-error-container/15 border border-error/25">
                                <span class="material-symbols-outlined text-[16px] text-error shrink-0 mt-px" style="font-variation-settings: 'FILL' 1;">
                                    error
                                </span>
                            <p class="text-error text-[12px] font-medium leading-relaxed tracking-wide">{{ $message }}</p>
                        </div>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="pt-2">
                        <flux:button
                            type="submit"
                            variant="primary"
                            class="w-full bg-primary-container text-on-primary-container hover:bg-primary transition duration-200 focus:outline-none focus:ring-2 focus:ring-primary-fixed active:scale-[0.99] flex items-center justify-center gap-space-sm !py-3.5 !rounded-xl"
                            data-test="register-user-button"
                        >
                            <span wire:loading.remove wire:target="submit" class="inline-flex items-center justify-center gap-2">
                                {{ __('Create account') }}
                                <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                            </span>
                            <span wire:loading wire:target="submit" class="inline-flex items-center justify-center gap-2">
                                {{ __('Creating account…') }}
                                <span class="material-symbols-outlined text-[20px] animate-spin">progress_activity</span>
                            </span>
                        </flux:button>
                    </div>
                </form>

                {{-- Divider --}}
                <div class="relative flex items-center justify-center my-space-md">
                    <div class="w-full h-px bg-surface-variant"></div>
                    <span class="absolute bg-surface-container px-space-sm font-label-sm text-label-sm text-outline tracking-widest uppercase">
                        OR
                    </span>
                </div>

                {{-- Google OAuth --}}
                <a
                    href="{{ route('auth.google') }}"
                    class="w-full bg-surface-container-high hover:bg-surface-variant text-on-surface py-3 rounded-xl font-label-lg text-label-lg font-medium transition duration-200 flex items-center justify-center gap-space-sm shadow-sm"
                >
                    <svg class="w-4 h-4" viewBox="0 0 24 24">
                        <path d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.8-2.4 3.66v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.15z" fill="#4285F4"/>
                        <path d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24z" fill="#34A853"/>
                        <path d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.99 0 12s.45 3.82 1.25 5.42l4.03-3.15z" fill="#FBBC05"/>
                        <path d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z" fill="#EA4335"/>
                    </svg>
                    <span>Continue with Google</span>
                </a>

                {{-- Desktop-only: login link inside card --}}
                <div class="hidden lg:block text-center pt-space-lg">
                    <p class="font-label-md text-label-md text-secondary">
                        Already have an account?
                        <a href="{{ route('login') }}" wire:navigate class="text-primary font-semibold hover:text-primary-fixed underline transition ml-1">
                            Log in
                        </a>
                    </p>
                </div>
            </div>

            {{-- Mobile-only: login link outside card --}}
            <div class="lg:hidden flex items-center justify-center space-x-1.5 mt-6 text-center">
                <span class="font-body-sm text-body-sm text-outline">Already have an account?</span>
                <a href="{{ route('login') }}" wire:navigate class="font-label-md text-label-md text-primary hover:text-primary-fixed transition-colors">
                    Log in
                </a>
            </div>
        </div>
    </main>
</div>
