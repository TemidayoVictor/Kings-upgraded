{{-- resources/views/livewire/shop/about.blade.php --}}
<div class="min-h-screen bg-[#f7f6f2] text-neutral-800 antialiased selection:bg-[var(--primary)] selection:text-white">

    <!-- Top Breadcrumb/Title Context Block -->
    <div class="w-full bg-white border-b border-neutral-200 py-4 sm:py-5">
        <div class="max-w-6xl mx-auto px-4 text-xs sm:text-sm font-medium tracking-wide text-neutral-500">
            <span class="hover:text-neutral-800 transition-colors">Home</span>
            <span class="mx-2 text-neutral-300">/</span>
            <span class="text-neutral-900 font-semibold">About us</span>
        </div>
    </div>

    <!-- Main Content Grid Component Frame -->
    <div class="max-w-6xl mx-auto px-4 py-10 sm:py-20">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-16 items-start">

            <!-- Left Column: Full-Size Responsive Image Wrapper -->
            @if($brand->image)
                <div class="md:col-span-5 md:sticky md:top-8 w-full">
                    <div class="w-full bg-white rounded-2xl overflow-hidden shadow-sm border border-neutral-200/60">
                        <img
                            src="{{ asset('storage/' . $brand->image) }}"
                            alt="{{ $brand->brand_name }} Brand Showcase"
                            class="w-full h-auto max-h-[70vh] md:max-h-[none] object-contain md:object-cover mx-auto"
                        >
                    </div>
                </div>
            @endif

            <!-- Right Column: Content, Context & Contact Details -->
            <div class="{{ $brand->image ? 'md:col-span-7' : 'md:col-span-12 max-w-3xl mx-auto' }} space-y-10 sm:space-y-12">

                <!-- Brand Identity Title Frame -->
                <div class="space-y-3">
                    <h1 class="text-3xl sm:text-5xl font-semibold tracking-tight text-neutral-950 font-serif">
                        About {{ $brand->brand_name }}
                    </h1>
                    @if($brand->motto)
                        <p class="text-base sm:text-lg italic text-neutral-500 font-serif">
                            "{{ $brand->motto }}"
                        </p>
                    @endif
                </div>

                <!-- Narrative Body Description -->
                @if($brand->about || $brand->description)
                    <div class="text-base sm:text-lg text-neutral-700 leading-relaxed whitespace-pre-line font-serif tracking-wide">
                        {!! nl2br(e($brand->about ?? $brand->description)) !!}
                    </div>
                @endif

                <!-- Highlighted Contact Box Element -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-neutral-200/80 shadow-xs space-y-6">
                    <div class="space-y-1">
                        <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-neutral-900">
                            Get in Touch
                        </h2>
                        <p class="text-xs sm:text-sm text-neutral-500">
                            Have questions or want to reach out? Contact us directly.
                        </p>
                    </div>

                    <!-- Contact Channels Sub-Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-neutral-100">
                        @if($brand->brand_email)
                            <div class="space-y-1">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-400 block">Email Us</span>
                                <a href="mailto:{{ $brand->brand_email }}" class="text-sm sm:text-base font-medium text-neutral-900 hover:text-[var(--primary)] transition-colors inline-block break-all underline decoration-neutral-200 underline-offset-4 hover:decoration-[var(--primary)]">
                                    {{ $brand->brand_email }}
                                </a>
                            </div>
                        @endif

                        @if($brand->city || $brand->state || $brand->address)
                            <div class="space-y-1">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-400 block">Our Location</span>
                                <p class="text-sm sm:text-base font-medium text-neutral-900 leading-relaxed">
                                    {{ $brand->address ? $brand->address . ', ' : '' }}
                                    {{ $brand->city }}{{ $brand->city && $brand->state ? ', ' : '' }}
                                    {{ $brand->state }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- Messaging & Social Anchors Framework -->
                    @if($brand->instagram || $brand->facebook || $brand->twitter || $brand->youtube || $brand->tiktok || $brand->linkedin || $brand->website)
                        <div class="pt-6 border-t border-neutral-100 space-y-3">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-400 block">Follow & Message Us</span>
                            <div class="flex flex-wrap gap-2">

                                <!-- WhatsApp Context Channel Button link -->
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $brand->brand_email) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-600 border border-emerald-200/60 hover:border-emerald-600 text-xs font-semibold text-emerald-700 hover:text-white transition-all active:scale-95">
                                    <i class="fa-brands fa-whatsapp text-sm"></i> <span>WhatsApp Chat</span>
                                </a>

                                @if($brand->instagram)
                                    <a href="https://instagram.com/{{ trim($brand->instagram, '@') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-neutral-200 text-xs font-medium text-neutral-700 hover:text-white hover:bg-[var(--primary)] hover:border-[var(--primary)] transition-all active:scale-95">
                                        <i class="fa-brands fa-instagram text-sm"></i> <span>Instagram</span>
                                    </a>
                                @endif

                                @if($brand->facebook)
                                    <a href="{{ $brand->facebook }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-neutral-200 text-xs font-medium text-neutral-700 hover:text-white hover:bg-[var(--primary)] hover:border-[var(--primary)] transition-all active:scale-95">
                                        <i class="fa-brands fa-facebook-f text-sm"></i> <span>Facebook</span>
                                    </a>
                                @endif

                                @if($brand->twitter)
                                    <a href="https://twitter.com/{{ trim($brand->twitter, '@') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-neutral-200 text-xs font-medium text-neutral-700 hover:text-white hover:bg-[var(--primary)] hover:border-[var(--primary)] transition-all active:scale-95">
                                        <i class="fa-brands fa-x-twitter text-sm"></i> <span>Twitter</span>
                                    </a>
                                @endif

                                @if($brand->tiktok)
                                    <a href="https://tiktok.com/@{{ trim($brand->tiktok, '@') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-neutral-200 text-xs font-medium text-neutral-700 hover:text-white hover:bg-[var(--primary)] hover:border-[var(--primary)] transition-all active:scale-95">
                                        <i class="fa-brands fa-tiktok text-sm"></i> <span>TikTok</span>
                                    </a>
                                @endif

                                @if($brand->youtube)
                                    <a href="{{ $brand->youtube }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-neutral-200 text-xs font-medium text-neutral-700 hover:text-white hover:bg-[var(--primary)] hover:border-[var(--primary)] transition-all active:scale-95">
                                        <i class="fa-brands fa-youtube text-sm"></i> <span>YouTube</span>
                                    </a>
                                @endif

                                @if($brand->linkedin)
                                    <a href="{{ $brand->linkedin }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-neutral-200 text-xs font-medium text-neutral-700 hover:text-white hover:bg-[var(--primary)] hover:border-[var(--primary)] transition-all active:scale-95">
                                        <i class="fa-brands fa-linkedin-in text-sm"></i> <span>LinkedIn</span>
                                    </a>
                                @endif

                                @if($brand->website)
                                    <a href="{{ $brand->website }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-neutral-200 text-xs font-medium text-neutral-700 hover:text-white hover:bg-[var(--primary)] hover:border-[var(--primary)] transition-all active:scale-95">
                                        <i class="fa-solid fa-globe text-sm"></i> <span>Main Website</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
