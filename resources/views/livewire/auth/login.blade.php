<div>
    <main class="relative z-10 w-full min-h-screen flex items-center justify-center px-gutter-mobile lg:px-gutter py-6 lg:py-space-xl pt-safe pb-safe">
        <div class="w-full max-w-7xl mx-auto">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-space-lg lg:gap-space-xl items-center min-h-[calc(100vh-6rem)]">

                {{-- ==================== LEFT: FORM COLUMN ==================== --}}
                    <div class="flex flex-col justify-center items-center w-full">
                        {{-- Form card --}}
                        <div class="w-full max-w-[384px] mx-auto bg-surface-container/60 backdrop-blur-md rounded-2xl p-space-lg lg:p-space-xl shadow-xl relative">

                            <div>
                                <div class="flex justify-center mb-space-sm">
                                    <a href="{{ route('home') }}" class="transition-transform duration-300 hover:scale-105">
                                        <img src="{{ asset('images/Logo-Crown.svg') }}" alt="KING'S Crown Logo" class="w-12 h-12 object-contain filter drop-shadow-[0_2px_12px_rgba(233,163,93,0.35)]" />
                                    </a>
                                </div>
                                <div class="text-center mb-space-lg">
                                    <h1 class="font-headline-lg text-headline-lg tracking-tight text-on-surface mb-space-xs font-semibold">
                                        Ollo, Welcome back
                                    </h1>
                                    <p class="font-label-sm text-label-sm tracking-[0.16em] uppercase text-outline">
                                        Sign in to your account
                                    </p>
                                </div>
                            </div>

                            {{-- ==================== FORM ==================== --}}
                            <form wire:submit="login" class="space-y-space-md">

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
                                    <div class="flex items-center justify-between">
                                        <label class="block font-label-md text-label-md text-on-surface-variant font-medium" for="password">
                                            Password
                                        </label>
                                        <a href="{{ route('password.request') }}" wire:navigate class="font-label-md text-label-md text-primary hover:text-primary-fixed underline transition mb-3">
                                            Forgot your password?
                                        </a>
                                    </div>
                                    <div class="relative">
                                        <input
                                            id="password"
                                            name="password"
                                            type="password"
                                            x-bind:type="showPw ? 'text' : 'password'"
                                            required
                                            autocomplete="current-password"
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

                                {{-- Remember --}}
                                <div class="flex items-center justify-between pt-space-xs">
                                    <label class="flex items-center gap-space-sm cursor-pointer select-none">
                                        <input type="checkbox" class="peer sr-only" />
                                        <span class="w-4 h-4 rounded bg-surface-container-highest flex items-center justify-center transition peer-checked:bg-primary-container">
                                            <span class="material-symbols-outlined text-surface-container-lowest text-[13px] font-bold opacity-0 peer-checked:opacity-100 transition-opacity">check</span>
                                        </span>
                                        <span class="font-label-md text-label-md text-secondary">
                                            Remember me for 30 days
                                        </span>
                                    </label>
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
                                    {{ __('LOGIN') }}
                                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                                </span>
                                        <span wire:loading wire:target="submit" class="inline-flex items-center justify-center gap-2">
                                    {{ __('Signing In…') }}
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

                            {{-- Desktop-only: signup inside card --}}
                            <div class="hidden lg:block text-center pt-space-lg">
                                <p class="font-label-md text-label-md text-secondary">
                                    First time around here?
                                    <a href="{{ route('signup') }}" wire:navigate class="text-primary font-semibold hover:text-primary-fixed underline transition ml-1">
                                        Sign up for free
                                    </a>
                                </p>
                            </div>
                        </div>

                        {{-- Mobile-only: signup outside card --}}
                        <div class="lg:hidden flex items-center justify-center space-x-1.5 mt-6 text-center max-w-[384px]">
                            <span class="font-body-sm text-body-sm text-outline">First time around here?</span>
                            <a href="{{ route('signup') }}" wire:navigate class="font-label-md text-label-md text-primary hover:text-primary-fixed transition-colors">
                                Sign up for free
                            </a>
                        </div>
                    </div>

                {{-- ==================== RIGHT: BILLBOARD (DESKTOP ONLY) ==================== --}}

                <div class="hidden lg:flex flex-col relative h-[640px] rounded-[32px] overflow-hidden shadow-2xl bg-surface-container-low group">
                    <img
                        src="{{ asset('images/aurora-2.jpg') }}"
                        alt="Discover brands and products on KING'S"
                        class="absolute inset-0 w-full h-full object-cover scale-105 group-hover:scale-100 transition-transform duration-700 ease-out"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-surface/60 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-surface-container-lowest/40 to-transparent"></div>

                    {{-- Bottom editorial block --}}
                    <div class="p-space-xl mt-auto relative z-10 flex flex-col">
                        <div class="flex items-center gap-1.5 mb-space-md text-primary">
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                        </div>

                        <h2 class="font-headline-lg text-headline-lg font-semibold text-on-surface leading-snug max-w-lg mb-space-sm drop-shadow-md">
                            Great products deserve a wider market. We make the connection.
                        </h2>

                        <p class="font-body-md text-body-md text-secondary max-w-md">
                            KING'S brings brands, sales partners, and shoppers together. Discover products, find new opportunities, and turn great offerings into more sales.
                        </p>

                        <div class="mt-space-lg pt-space-md flex items-center gap-space-lg bg-surface-container-lowest/40 backdrop-blur-sm rounded-xl px-space-md py-space-sm">
                            <div>
                                <div class="font-headline-sm text-headline-sm font-semibold text-primary">Brands</div>
                                <div class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Showcase Products</div>
                            </div>
                            <div class="w-px h-8 bg-surface-variant"></div>
                            <div>
                                <div class="font-headline-sm text-headline-sm font-semibold text-on-surface">Partners</div>
                                <div class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Grow Through Sales</div>
                            </div>
                            <div class="w-px h-8 bg-surface-variant"></div>
                            <div>
                                <div class="font-headline-sm text-headline-sm font-semibold text-on-surface">Shoppers</div>
                                <div class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Discover & Shop</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>
