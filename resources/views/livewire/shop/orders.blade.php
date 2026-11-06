<div class="min-h-screen bg-[var(--surface)] py-8 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Header --}}
        <div class="border-b border-[var(--outline-variant)]/30 pb-6 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <span class="text-[10px] font-semibold uppercase tracking-[0.22em] text-[var(--secondary)] block mb-2">
                    Your Account
                </span>
                <h1 class="font-editorial text-2xl sm:text-4xl lg:text-5xl tracking-tight text-[var(--on-surface)] uppercase">
                    All Orders
                </h1>
            </div>
            <p class="text-xs sm:text-sm text-[var(--outline)] font-light tracking-wide">
                Showing your recent orders record
            </p>
        </div>

        {{-- Stat cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            @foreach([
                ['Total Orders', number_format($totalOrders)],
                ['Total Revenue', '₦' . number_format($totalRevenue)],
                ['Pending Orders', number_format($pendingOrders)],
                ['Average Order Value', '₦' . number_format($avgOrderValue)],
            ] as [$label, $value])
                <div class="bg-white rounded-2xl border border-[var(--outline-variant)]/25 p-5 sm:p-6 shadow-xs relative overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-[var(--secondary)]"></div>
                    <div class="space-y-1">
                        <span class="text-[10px] text-[var(--outline)] font-semibold uppercase tracking-wider block">{{ $label }}</span>
                        <h3 class="text-2xl sm:text-3xl font-light text-[var(--on-surface)] tracking-tight">{{ $value }}</h3>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Orders container --}}
        <div class="bg-white rounded-2xl border border-[var(--outline-variant)]/25 shadow-xs overflow-hidden">
            @if($orders->count() > 0)
                @php
                    $statusColors = [
                        'pending' => 'bg-amber-50 text-amber-700 border-amber-200/60',
                        'processing' => 'bg-blue-50 text-blue-700 border-blue-200/60',
                        'shipped' => 'bg-indigo-50 text-indigo-700 border-indigo-200/60',
                        'delivered' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
                        'cancelled' => 'bg-neutral-50 text-neutral-600 border-neutral-200',
                    ];
                @endphp

                {{-- Desktop table --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full border-collapse text-left">
                        <thead>
                        <tr class="bg-[var(--surface-low)]/70 border-b border-[var(--outline-variant)]/30 text-[10px] font-semibold uppercase tracking-[0.2em] text-[var(--outline)]">
                            <th class="px-6 py-4 font-semibold">Order Number</th>
                            <th class="px-6 py-4 font-semibold">Date</th>
                            <th class="px-6 py-4 font-semibold">Customer Details</th>
                            <th class="px-6 py-4 font-semibold">Order Status</th>
                            <th class="px-6 py-4 font-semibold">Payment Status</th>
                            <th class="px-6 py-4 font-semibold text-right">Total Price</th>
                            <th class="px-6 py-4 text-right"></th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-[var(--outline-variant)]/20 text-xs text-[var(--on-surface-variant)]">
                        @foreach($orders as $order)
                            <tr class="hover:bg-[var(--surface-low)]/40 transition-colors group" wire:key="desktop-row-{{ $order->id }}">
                                <td class="px-6 py-5 font-mono font-medium text-[var(--on-surface)]">
                                    #{{ $order->order_number }}
                                </td>
                                <td class="px-6 py-5 text-[var(--outline)] font-light">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-5">
                                    <div class="space-y-0.5">
                                        <p class="font-medium text-[var(--on-surface)]">{{ $order->customer_name }}</p>
                                        <p class="text-[11px] text-[var(--outline)] font-light">{{ $order->customer_email }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-2.5 py-1 text-[10px] font-semibold tracking-wider uppercase rounded-md border {{ $statusColors[$order->status] ?? 'bg-neutral-50 text-neutral-600 border-neutral-200' }}">
                                            {{ $order->status }}
                                        </span>
                                </td>
                                <td class="px-6 py-5">
                                        <span class="inline-flex items-center gap-1.5 font-medium {{ $order->payment_status === 'paid' ? 'text-emerald-600' : 'text-[var(--outline)]' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $order->payment_status === 'paid' ? 'bg-emerald-500' : 'bg-[var(--outline-variant)]' }}"></span>
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                </td>
                                <td class="px-6 py-5 text-right font-semibold text-[var(--on-surface)]">
                                    ₦{{ number_format($order->total) }}
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <button
                                        type="button"
                                        wire:click="viewOrder({{ $order->id }})"
                                        class="bg-[var(--surface-low)] hover:bg-[var(--primary)] text-[var(--on-surface-variant)] hover:text-white px-3 py-1.5 rounded-lg border border-[var(--outline-variant)]/30 hover:border-[var(--primary)] text-[11px] font-medium transition-all cursor-pointer"
                                    >
                                        View Details
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile cards --}}
                <div class="block md:hidden divide-y divide-[var(--outline-variant)]/20">
                    @foreach($orders as $order)
                        <div class="p-4 space-y-4" wire:key="mobile-row-{{ $order->id }}">
                            <div class="flex items-start justify-between">
                                <div class="space-y-1">
                                    <span class="font-mono text-xs font-bold text-[var(--on-surface)]">#{{ $order->order_number }}</span>
                                    <span class="block text-[11px] text-[var(--outline)] font-light">{{ $order->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="text-right font-semibold text-[var(--on-surface)] text-sm">
                                    ₦{{ number_format($order->total) }}
                                </div>
                            </div>

                            <div class="flex items-center justify-between text-xs">
                                <div>
                                    <p class="font-medium text-[var(--on-surface)] mb-0.5">{{ $order->customer_name }}</p>
                                    <span class="text-[var(--outline)] font-light">{{ $order->customer_phone }}</span>
                                </div>
                                <div class="flex flex-col items-end gap-1.5">
                                    <span class="inline-flex items-center px-2 py-0.5 text-[9px] font-semibold tracking-wider uppercase rounded-md border {{ $statusColors[$order->status] ?? 'bg-neutral-50 border-neutral-200' }}">
                                        {{ $order->status }}
                                    </span>
                                    <span class="text-[11px] font-medium {{ $order->payment_status === 'paid' ? 'text-emerald-600' : 'text-[var(--outline)]' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                            </div>

                            <button
                                type="button"
                                wire:click="viewOrder({{ $order->id }})"
                                class="w-full bg-[var(--surface-low)] text-[var(--on-surface-variant)] py-2.5 rounded-xl border border-[var(--outline-variant)]/30 text-xs font-semibold text-center block cursor-pointer hover:bg-[var(--primary)] hover:text-white hover:border-[var(--primary)] transition-all"
                            >
                                View Order Items
                            </button>
                        </div>
                    @endforeach
                </div>

                @if($orders->hasPages())
                    <div class="px-6 py-4 border-t border-[var(--outline-variant)]/30">
                        <flux:pagination :paginator="$orders" />
                    </div>
                @endif
            @else
                <div class="text-center py-20 max-w-xs mx-auto space-y-4">
                    <div class="w-14 h-14 bg-[var(--surface-low)] rounded-full flex items-center justify-center mx-auto border border-[var(--outline-variant)]/30 text-[var(--outline-variant)]">
                        <i class="fa-solid fa-folder-open text-lg"></i>
                    </div>
                    <h3 class="font-editorial text-xl text-[var(--on-surface)]">No orders found</h3>
                    <p class="text-xs text-[var(--outline)] font-light leading-relaxed">
                        There are currently no orders saved in the system.
                    </p>
                </div>
            @endif
        </div>
    </div>

    {{-- Order drawer --}}
    @if($showOrderModal && $selectedOrder)
        <div class="fixed inset-0 z-50 flex justify-end" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" wire:click="closeOrderModal"></div>

            <div class="relative w-full max-w-md bg-white h-full shadow-2xl flex flex-col justify-between border-l border-[var(--outline-variant)]/30 z-10 overflow-hidden order-drawer">

                {{-- Header --}}
                <div class="p-6 border-b border-[var(--outline-variant)]/30 flex items-center justify-between bg-[var(--surface-low)]/60">
                    <div>
                        <span class="text-[10px] font-mono text-[var(--outline)] block font-bold uppercase tracking-widest">Order Invoice</span>
                        <h2 class="font-editorial text-lg text-[var(--on-surface)] tracking-tight mt-0.5">Order #{{ $selectedOrder->order_number }}</h2>
                    </div>
                    <button
                        type="button"
                        wire:click="closeOrderModal"
                        class="w-8 h-8 rounded-full border border-[var(--outline-variant)]/40 text-[var(--outline)] hover:text-[var(--on-surface)] hover:border-[var(--on-surface)] bg-white flex items-center justify-center transition-all cursor-pointer"
                    >
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </button>
                </div>

                {{-- Body --}}
                <div class="p-6 flex-1 overflow-y-auto space-y-6 text-xs text-[var(--on-surface-variant)]">

                    {{-- Customer --}}
                    <div class="space-y-3">
                        <h4 class="text-[10px] uppercase font-semibold tracking-widest text-[var(--outline)]">Customer Details</h4>
                        <div class="bg-[var(--surface-low)]/70 border border-[var(--outline-variant)]/30 rounded-xl p-4 space-y-2">
                            <div class="flex justify-between"><span class="text-[var(--outline)] font-light">Name:</span><span class="font-medium text-[var(--on-surface)]">{{ $selectedOrder->customer_name }}</span></div>
                            <div class="flex justify-between gap-3"><span class="text-[var(--outline)] font-light shrink-0">Email:</span><span class="font-medium text-[var(--on-surface)] font-mono truncate">{{ $selectedOrder->customer_email }}</span></div>
                            <div class="flex justify-between"><span class="text-[var(--outline)] font-light">Phone:</span><span class="font-medium text-[var(--on-surface)]">{{ $selectedOrder->customer_phone }}</span></div>
                        </div>
                    </div>

                    {{-- Items --}}
                    <div class="space-y-3">
                        <h4 class="text-[10px] uppercase font-semibold tracking-widest text-[var(--outline)]">Items Purchased</h4>
                        <div class="space-y-3">
                            @foreach($selectedOrder->items as $item)
                                <div class="bg-white rounded-xl border border-[var(--outline-variant)]/30 p-4 shadow-2xs flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

                                    <div class="flex items-center gap-4 min-w-0 flex-1">
                                        <div class="w-16 h-20 bg-[var(--surface-low)] rounded-xl overflow-hidden shrink-0">
                                            @if($item->product && $item->product->images->count() > 0)
                                                <img
                                                    src="{{ $item->product->primary_image_url }}"
                                                    alt="{{ $item->product_name }}"
                                                    class="w-full h-full object-cover"
                                                >
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <span class="text-[var(--outline)] text-[10px] font-bold uppercase tracking-wider">
                                                        {{ substr($item->product_name, 0, 2) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="space-y-1 min-w-0 flex-1">
                                            <h5 class="font-medium text-[var(--on-surface)] text-xs sm:text-sm truncate">
                                                {{ $item->product_name }}
                                            </h5>

                                            <div class="flex flex-wrap items-center gap-2 text-[11px] text-[var(--outline)] font-light">
                                                <span>Qty: <strong class="text-[var(--on-surface)] font-medium">{{ $item->quantity }}</strong></span>
                                                <span>•</span>
                                                <span>Unit Price: <strong class="text-[var(--on-surface)] font-medium">₦{{ number_format($item->unit_price) }}</strong></span>
                                            </div>

                                            @if($item->sku)
                                                <div class="pt-0.5">
                                                    <span class="inline-block text-[9px] text-[var(--outline)] bg-[var(--surface-low)] border border-[var(--outline-variant)]/40 px-1.5 py-0.5 rounded font-mono">
                                                        SKU: {{ $item->sku }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="text-left sm:text-right pt-2 sm:pt-0 border-t sm:border-t-0 border-[var(--outline-variant)]/20 shrink-0 flex sm:flex-col justify-between items-center sm:items-end">
                                        <span class="text-[10px] text-[var(--outline)] font-light block sm:hidden">Subtotal:</span>
                                        <span class="font-semibold text-[var(--on-surface)] text-sm">₦{{ number_format($item->total) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="p-6 border-t border-[var(--outline-variant)]/30 bg-[var(--surface-low)]/80 space-y-1.5">
                    <div class="flex justify-between items-baseline">
                        <span class="text-xs font-medium text-[var(--outline)] uppercase tracking-wider">Total Due</span>
                        <span class="text-xl font-semibold text-[var(--on-surface)]">₦{{ number_format($selectedOrder->total) }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Drawer slide-in animation --}}
    <style>
        @keyframes order-drawer-slide {
            from { transform: translateX(100%); opacity: 0.6; }
            to   { transform: translateX(0);    opacity: 1; }
        }
        .order-drawer {
            animation: order-drawer-slide 0.28s cubic-bezier(0.16, 1, 0.3, 1);
        }
    </style>
</div>
