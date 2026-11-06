<div class="min-h-screen bg-[var(--surface)] py-8 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">

            {{-- ================= LEFT: Summary + Form (sticky) ================= --}}
            <div class="lg:col-span-5 lg:sticky lg:top-32 space-y-8">

                {{-- Header + average --}}
                <div class="space-y-3">
                    <span class="text-[10px] font-semibold uppercase tracking-[0.22em] text-[var(--secondary)] block">
                        Customer Reviews
                    </span>
                    <h1 class="font-editorial text-3xl sm:text-4xl lg:text-5xl text-[var(--on-surface)] tracking-tight uppercase leading-[1.05]">
                        {{ $brand->brand_name }}
                    </h1>

                    <div class="flex items-baseline gap-4 pt-4">
                        <span class="font-editorial text-6xl sm:text-7xl text-[var(--on-surface)] leading-none">
                            {{ number_format($avgRating, 1) }}
                        </span>
                        <div class="space-y-1">
                            <div class="flex text-[var(--secondary)] text-sm gap-0.5">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa-{{ $i <= round($avgRating) ? 'solid' : 'regular' }} fa-star"></i>
                                @endfor
                            </div>
                            <p class="text-xs text-[var(--outline)]">
                                Based on {{ $reviews->count() }} {{ Str::plural('review', $reviews->count()) }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Rating breakdown --}}
                @if($reviews->count() > 0)
                    @php
                        $breakdown = [];
                        for ($i = 5; $i >= 1; $i--) {
                            $count = $reviews->where('rating', $i)->count();
                            $percent = $reviews->count() > 0 ? round(($count / $reviews->count()) * 100) : 0;
                            $breakdown[$i] = ['count' => $count, 'percent' => $percent];
                        }
                    @endphp
                    <div class="bg-white rounded-2xl border border-[var(--outline-variant)]/25 p-5 sm:p-6 space-y-3">
                        <h3 class="text-[10px] font-semibold uppercase tracking-widest text-[var(--outline)]">
                            Rating Breakdown
                        </h3>
                        @foreach($breakdown as $stars => $data)
                            <div class="flex items-center gap-3 text-xs">
                                <span class="w-8 text-[var(--on-surface-variant)] text-right text-[11px] font-medium">{{ $stars }}★</span>
                                <div class="flex-1 h-1.5 bg-[var(--surface-container)] rounded-full overflow-hidden">
                                    <div class="h-full bg-[var(--secondary)] rounded-full transition-all"
                                         style="width: {{ $data['percent'] }}%"></div>
                                </div>
                                <span class="w-12 text-right text-[11px] text-[var(--outline)]">
                                    {{ $data['percent'] }}% <span class="opacity-60">({{ $data['count'] }})</span>
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Write / update review --}}
                @auth
                    <div class="bg-white rounded-2xl border border-[var(--outline-variant)]/25 p-6 sm:p-8 space-y-6">
                        <div class="space-y-1">
                            <h2 class="font-editorial text-xl text-[var(--on-surface)]">
                                {{ $hasReviewed ? 'Update your review' : 'Write a review' }}
                            </h2>
                            <p class="text-xs text-[var(--outline)]">
                                {{ $hasReviewed ? 'You have already reviewed this brand. You can update your rating or comment below.' : 'Share your experience with this brand with the community.' }}
                            </p>
                        </div>

                        <form wire:submit.prevent="saveReview" class="space-y-5">
                            {{-- Stars --}}
                            <div class="space-y-2">
                                <span class="text-[10px] font-semibold uppercase tracking-widest text-[var(--outline)] block">
                                    Your Rating
                                </span>
                                <div class="flex items-center gap-1.5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button
                                            type="button"
                                            wire:click="$set('rating', {{ $i }})"
                                            class="text-2xl transition-all hover:scale-110 active:scale-95 cursor-pointer {{ $i <= $rating ? 'text-[var(--secondary)]' : 'text-[var(--outline-variant)] hover:text-[var(--secondary)]' }}"
                                        >
                                            <i class="fa-solid fa-star"></i>
                                        </button>
                                    @endfor
                                </div>
                                @error('rating')
                                <span class="text-xs text-rose-500 block">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Textarea --}}
                            <div class="space-y-2">
                                <span class="text-[10px] font-semibold uppercase tracking-widest text-[var(--outline)] block">
                                    Your Comments
                                </span>
                                <textarea
                                    id="comment"
                                    wire:model="review"
                                    rows="4"
                                    placeholder="Tell us what you think..."
                                    class="w-full rounded-xl border border-[var(--outline-variant)]/40 bg-[var(--surface-low)] px-4 py-3 text-sm text-[var(--on-surface)] placeholder:text-[var(--outline)] focus:border-[var(--on-surface)] focus:outline-none transition-all resize-none"
                                ></textarea>
                                @error('review')
                                <span class="text-xs text-rose-500 block">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Submit --}}
                            <div class="flex items-center justify-between gap-3 pt-1">
                                @if(session()->has('message'))
                                    <span class="text-xs text-emerald-600 font-medium flex items-center gap-1.5">
                                        <i class="fa-solid fa-circle-check text-xs"></i>
                                        {{ session('message') }}
                                    </span>
                                @else
                                    <div></div>
                                @endif

                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-[var(--primary)] hover:bg-[var(--secondary)] text-white text-xs font-semibold transition-all active:scale-[0.98] cursor-pointer shadow-md"
                                >
                                    <i class="fa-solid {{ $hasReviewed ? 'fa-rotate' : 'fa-plus' }} text-xs"></i>
                                    <span>{{ $hasReviewed ? 'Update Review' : 'Submit Review' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="bg-white rounded-2xl border border-[var(--outline-variant)]/25 p-6 space-y-3">
                        <p class="text-xs text-[var(--outline)]">
                            Want to leave a review? Please sign in to your account first.
                        </p>
                        <a href="{{ route('login') }}"
                           class="inline-flex text-xs font-semibold text-[var(--primary)] underline underline-offset-4 hover:text-[var(--secondary)] transition-colors">
                            Sign in here
                        </a>
                    </div>
                @endauth
            </div>

            {{-- ================= RIGHT: Reviews list ================= --}}
            <div class="lg:col-span-7 space-y-6">

                <div class="flex items-center justify-between border-b border-[var(--outline-variant)]/30 pb-3">
                    <h3 class="text-[10px] font-semibold uppercase tracking-widest text-[var(--outline)]">
                        All Reviews
                    </h3>
                    <span class="text-xs text-[var(--outline)]">
                        {{ $reviews->count() }} public reviews
                    </span>
                </div>

                @if($reviews->isEmpty())
                    <div class="text-center py-20 px-4 space-y-3 max-w-sm mx-auto bg-white rounded-2xl border border-[var(--outline-variant)]/25">
                        <div class="w-14 h-14 bg-[var(--surface-low)] rounded-full flex items-center justify-center mx-auto border border-[var(--outline-variant)]/30 text-[var(--outline-variant)]">
                            <i class="fa-regular fa-star text-lg"></i>
                        </div>
                        <h4 class="font-editorial text-lg text-[var(--on-surface)]">No reviews yet</h4>
                        <p class="text-xs text-[var(--outline)] leading-relaxed">
                            Nobody has written a review for this brand yet. Be the first one to share your thoughts!
                        </p>
                    </div>
                @else
                    <div class="divide-y divide-[var(--outline-variant)]/20 bg-white rounded-2xl border border-[var(--outline-variant)]/25 overflow-hidden">
                        @foreach($reviews as $review)
                            <div class="p-6 space-y-4 group">

                                {{-- Meta row --}}
                                <div class="flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-9 h-9 rounded-full bg-[var(--surface-container)] text-[var(--on-surface-variant)] font-medium text-xs flex items-center justify-center border border-[var(--outline-variant)]/30 shrink-0">
                                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <h5 class="text-sm font-medium text-[var(--on-surface)] flex items-center gap-2">
                                                <span class="truncate">{{ $review->user->name }}</span>
                                                @auth
                                                    @if($review->user_id === auth()->id())
                                                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-[var(--primary)] text-white font-semibold uppercase tracking-wider shrink-0">
                                                            You
                                                        </span>
                                                    @endif
                                                @endauth
                                            </h5>
                                            <p class="text-[10px] text-[var(--outline)]">
                                                {{ $review->updated_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex text-[var(--secondary)] text-[10px] gap-0.5 shrink-0">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                                        @endfor
                                    </div>
                                </div>

                                {{-- Body --}}
                                @if($review->review)
                                    <p class="text-sm text-[var(--on-surface-variant)] leading-relaxed font-light group-hover:text-[var(--on-surface)] transition-colors">
                                        {{ $review->review }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
