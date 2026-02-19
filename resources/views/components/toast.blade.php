@props([
    'position' => 'top-right', // top-right, top-left, bottom-right, bottom-left, top-center, bottom-center
    'duration' => 5000, // milliseconds
])

<div
    x-data="toast({
        position: '{{ $position }}',
        duration: {{ $duration }}
    })"
    x-init="init();
    @if(session()->has('toast'))
        add(@js(session('toast')));
    @endif"
    @notify.window="add($event.detail[0])"
    @clear-toasts.window="clear()"
    class="fixed z-50 pointer-events-none inset-0"
    x-cloak
>
    {{-- Toast Container --}}
    <div
        x-show="toasts.length > 0"
        x-transition
        class="absolute inset-0"
    >
        {{-- Position Wrapper - Responsive! --}}
        <div class="{{
            match($position) {
                'top-left' => 'top-0 left-0 sm:ml-4 sm:mt-4',
                'top-right' => 'top-0 right-0 sm:mr-4 sm:mt-4',
                'top-center' => 'top-0 left-1/2 -translate-x-1/2 sm:mt-4',
                'bottom-left' => 'bottom-0 left-0 sm:ml-4 sm:mb-4',
                'bottom-right' => 'bottom-0 right-0 sm:mr-4 sm:mb-4',
                'bottom-center' => 'bottom-0 left-1/2 -translate-x-1/2 sm:mb-4',
                default => 'top-0 right-0 sm:mr-4 sm:mt-4',
            }
        }} absolute flex flex-col gap-3 w-full sm:max-w-sm pointer-events-auto">

            {{-- Mobile: Full width, Desktop: Floating --}}
            <template x-for="(toast, index) in toasts" :key="index">
                <div
                    x-show="toast.show"
                    x-transition:enter="transform ease-out duration-300 transition"
                    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
{{--                    @mouseenter="$el.querySelector('.progress-bar').style.animationPlayState = 'paused'"--}}
{{--                    @mouseleave="$el.querySelector('.progress-bar').style.animationPlayState = 'running'"--}}
                    @click="remove(index)"
                    :class="{
                        'bg-emerald-50 border-emerald-200': toast.type === 'success',
                        'bg-rose-50 border-rose-200': toast.type === 'error',
                        'bg-amber-50 border-amber-200': toast.type === 'warning',
                        'bg-sky-50 border-sky-200': toast.type === 'info',
                        'sm:rounded-xl': true, // Desktop: rounded
                        'rounded-none': true,   // Mobile: no rounded corners
                    }"
                    class="overflow-hidden relative flex items-start gap-4 p-4 border shadow-lg backdrop-blur-sm cursor-pointer transition-all hover:shadow-xl w-full sm:w-auto"
                    role="alert"
                >
                    {{-- Progress Bar - Full width on mobile --}}
                    <div
                        x-show="toast.duration > 0"
                        class="progress-bar absolute bottom-0 left-0 h-1"
                        :class="{
                            'bg-emerald-500': toast.type === 'success',
                            'bg-rose-500': toast.type === 'error',
                            'bg-amber-500': toast.type === 'warning',
                            'bg-sky-500': toast.type === 'info',
                        }"
                        :style="`animation: shrink ${toast.duration}ms linear forwards;`"
                    ></div>

                    {{-- Icon --}}
                    <div class="flex-shrink-0">
                        <template x-if="toast.type === 'success'">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-5m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </template>
                        <template x-if="toast.type === 'error'">
                            <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </template>
                        <template x-if="toast.type === 'warning'">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </template>
                        <template x-if="toast.type === 'info'">
                            <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </template>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 pt-0.5 capitalize">
                        <p class="text-sm font-semibold" :class="{
                            'text-emerald-800': toast.type === 'success',
                            'text-rose-800': toast.type === 'error',
                            'text-amber-800': toast.type === 'warning',
                            'text-sky-800': toast.type === 'info',
                        }" x-text="toast.title || defaultTitle(toast.type)"></p>
                        <p class="mt-1 text-sm" :class="{
                            'text-emerald-700': toast.type === 'success',
                            'text-rose-700': toast.type === 'error',
                            'text-amber-700': toast.type === 'warning',
                            'text-sky-700': toast.type === 'info',
                        }" x-text="toast.message"></p>
                    </div>

                    {{-- Close Button --}}
                    <button @click.stop="remove(index)" class="flex-shrink-0 p-1 rounded-lg transition-colors" :class="{
                        'hover:bg-emerald-200/50 text-emerald-600': toast.type === 'success',
                        'hover:bg-rose-200/50 text-rose-600': toast.type === 'error',
                        'hover:bg-amber-200/50 text-amber-600': toast.type === 'warning',
                        'hover:bg-sky-200/50 text-sky-600': toast.type === 'info',
                    }">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </template>
        </div>
    </div>
</div>

{{-- Alpine Component --}}
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('toast', (config) => ({
            toasts: [],
            position: config.position || 'top-right',
            defaultDuration: config.duration || 5000,

            init() {},

            add(payload) {
                const id = Date.now() + Math.random();
                const toast = {
                    id,
                    type: payload.type || 'info',
                    title: payload.title || null,
                    message: payload.message || '',
                    duration: payload.duration ?? this.defaultDuration,
                    show: true,
                    progress: 100,
                    timer: null,
                    pause: false,
                };

                this.toasts.unshift(toast);
                this.startTimer(toast);
            },

            startTimer(toast) {
                if (toast.duration <= 0) return;

                toast.timer = setTimeout(() => {
                    this.removeById(toast.id);
                }, toast.duration);
            },

            pauseToast(index) {
                if (this.toasts[index]) {
                    this.toasts[index].pause = true;
                    clearInterval(this.toasts[index].timer);
                }
            },

            resumeToast(index) {
                if (this.toasts[index]) {
                    this.toasts[index].pause = false;
                    this.startTimer(this.toasts[index]);
                }
            },

            remove(index) {
                if (this.toasts[index]) {
                    clearInterval(this.toasts[index].timer);
                    this.toasts[index].show = false;
                    setTimeout(() => {
                        this.toasts = this.toasts.filter((_, i) => i !== index);
                    }, 200);
                }
            },

            removeById(id) {
                const index = this.toasts.findIndex(t => t.id === id);
                if (index !== -1) {
                    this.remove(index);
                }
            },

            clear() {
                this.toasts.forEach(toast => clearInterval(toast.timer));
                this.toasts = [];
            },

            defaultTitle(type) {
                const titles = {
                    success: 'Success!',
                    error: 'Error!',
                    warning: 'Warning!',
                    info: 'Info',
                };
                return titles[type] || 'Notification';
            },
        }));
    });
</script>

<style>
    [x-cloak] { display: none !important; }
    @keyframes shrink {
        from { width: 100%; }
        to { width: 0%; }
    }
</style>
