<div class="max-w-7xl mx-auto px-4 py-10 sm:py-16">
    <!-- Grid Wrapper: Main split architecture -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">

        <!-- ================= LEFT COLUMN: METRICS & INPUT FORM ================= -->
        <div class="lg:col-span-5 lg:sticky lg:top-8 space-y-10">

            <!-- Brand Header & Core Rating -->
            <div class="space-y-4">
                <span class="text-[10px] font-bold tracking-[3px] uppercase text-neutral-400 block">Customer Reviews</span>
                <h1 class="text-3xl sm:text-4xl font-normal tracking-tight text-neutral-950 font-serif leading-none">
                    {{ $brand->brand_name }}
                </h1>

                <!-- Numeric Focus Row -->
                <div class="flex items-baseline gap-4 pt-2">
                    <span class="text-6xl font-normal tracking-tighter text-neutral-950 font-sans">
                        {{ number_format($avgRating, 1) }}
                    </span>
                    <div class="space-y-1">
                        <div class="flex text-amber-400 text-xs gap-0.5">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= round($avgRating) ? 'solid' : 'regular' }} fa-star"></i>
                            @endfor
                        </div>
                        <p class="text-xs text-neutral-500 font-normal">
                            Based on {{ $reviews->count() }} {{ Str::plural('review', $reviews->count()) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Review Input Area -->
            @auth
                <div class="pt-8 border-t border-neutral-200/60 space-y-6">
                    <div class="space-y-1">
                        <h2 class="text-lg font-medium tracking-tight text-neutral-900 font-serif">
                            {{ $hasReviewed ? 'Update your review' : 'Write a review' }}
                        </h2>
                        <p class="text-xs text-neutral-500 font-normal">
                            {{ $hasReviewed ? 'You have already reviewed this brand. You can update your rating or comment below.' : 'Share your experience with this brand with the community.' }}
                        </p>
                    </div>

                    <form wire:submit.prevent="saveReview" class="space-y-6">
                        <!-- Star Selection -->
                        <div class="space-y-1.5">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-neutral-400 block">Your Rating</span>
                            <div class="flex items-center gap-1.5">
                                @for ($i = 1; $i <= 5; $i++)
                                    <button type="button" wire:click="$set('rating', {{ $i }})" class="text-xl transition-all duration-200 hover:scale-110 active:scale-95 focus:outline-hidden cursor-pointer {{ $i <= $rating ? 'text-amber-400' : 'text-neutral-200 hover:text-amber-300' }}">
                                        <i class="fa-solid fa-star"></i>
                                    </button>
                                @endfor
                            </div>
                            @error('rating') <span class="text-xs text-red-500 font-normal block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Textarea -->
                        <div class="space-y-1.5">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-neutral-400 block">Your Comments</span>
                            <textarea
                                id="comment"
                                wire:model="review"
                                rows="4"
                                placeholder="Tell us what you think..."
                                class="w-full rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm text-neutral-800 placeholder-neutral-400/80 focus:border-neutral-950 focus:outline-hidden focus:ring-1 focus:ring-neutral-950 transition-all font-sans leading-relaxed resize-none shadow-3xs"
                            ></textarea>
                            @error('review') <span class="text-xs text-red-500 font-normal block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Form Submission Button -->
                        <div class="flex items-center justify-between gap-4 pt-1">
                            @if(session()->has('message'))
                                <span class="text-xs text-emerald-600 font-medium flex items-center gap-1.5 animate-fade-in">
                                    <i class="fa-solid fa-circle-check text-xs"></i> {{ session('message') }}
                                </span>
                            @else
                                <div></div>
                            @endif

                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-neutral-950 hover:bg-neutral-800 text-xs font-semibold text-white transition-all active:scale-98 cursor-pointer shadow-xs">
                                <i class="fa-solid {{ $hasReviewed ? 'fa-rotate' : 'fa-plus' }} text-xs"></i>
                                <span>{{ $hasReviewed ? 'Update Review' : 'Submit Review' }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <!-- Unauthenticated Gateway -->
                <div class="pt-8 border-t border-neutral-200/60 space-y-3">
                    <p class="text-xs text-neutral-500 font-normal">
                        Want to leave a review? Please sign in to your account first.
                    </p>
                    <a href="{{ route('login') }}" class="inline-flex text-xs font-bold text-neutral-950 underline underline-offset-4 hover:text-neutral-600 transition-colors">
                        Sign in here
                    </a>
                </div>
            @endauth
        </div>

        <!-- ================= RIGHT COLUMN: REVIEWS LIST ================= -->
        <div class="lg:col-span-7 space-y-6">
            <div class="flex items-center justify-between border-b border-neutral-200/60 pb-3">
                <h3 class="text-[10px] font-bold uppercase tracking-widest text-neutral-400">All Reviews</h3>
                <span class="text-xs text-neutral-500 font-normal">{{ $reviews->count() }} public reviews</span>
            </div>

            @if($reviews->isEmpty())
                <!-- Empty State -->
                <div class="text-center py-20 px-4 space-y-3 max-w-sm mx-auto">
                    <i class="fa-solid fa-stars text-neutral-300 text-4xl block"></i>
                    <h4 class="text-base font-medium text-neutral-900 font-serif">No reviews yet</h4>
                    <p class="text-xs text-neutral-500 font-normal leading-relaxed">
                        Nobody has written a review for this brand yet. Be the first one to share your thoughts!
                    </p>
                </div>
            @else
                <!-- Review List Stream -->
                <div class="divide-y divide-neutral-100">
                    @foreach ($reviews as $review)
                        <div class="py-6 first:pt-0 last:pb-0 space-y-6 group transition-all">

                            <!-- Review Meta Info -->
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <!-- User Avatar Initial -->
                                    <div class="w-8 h-8 rounded-full bg-neutral-100 text-neutral-700 font-medium text-xs flex items-center justify-center border border-neutral-200/40">
                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h5 class="text-sm font-medium text-neutral-900 flex items-center gap-2">
                                            {{ $review->user->name }}
                                            @auth
                                                @if($review->user_id === auth()->id())
                                                    <span class="text-[9px] px-1.5 py-0.5 rounded bg-neutral-100 text-neutral-500 font-semibold uppercase tracking-wide">You</span>
                                                @endif
                                            @endauth
                                        </h5>
                                        <p class="text-[10px] text-neutral-500 font-normal">
                                            {{ $review->updated_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Stars Display -->
                                <div class="flex text-amber-400 text-[10px] gap-0.5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                                    @endfor
                                </div>
                            </div>

                            <!-- User Message Text Body -->
                            @if($review->review)
                                <div>
                                    <p class="text-sm text-neutral-600 leading-relaxed font-sans font-normal group-hover:text-neutral-900 transition-colors">
                                        {{ $review->review }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>
