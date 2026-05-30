<div class="min-h-screen bg-[#faf9f6] py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <div class="border-b border-neutral-200/60 pb-6 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-[3px] text-neutral-400 block mb-1">
                    @if($admin) Administrator @elseif($user) Your Account @else Brand Partner @endif
                </span>
                <h1 class="text-2xl sm:text-4xl font-light tracking-tight text-neutral-900 serif-display">All Orders</h1>
            </div>
            <div>
                <p class="text-xs sm:text-sm text-neutral-500 font-light tracking-wide">
                    Showing your recent orders record
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white rounded-2xl border border-neutral-100 p-6 flex flex-col justify-between shadow-xs">
                <div class="space-y-1">
                    <span class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider block">Total Orders</span>
                    <h3 class="text-3xl font-light text-neutral-900 tracking-tight">{{ number_format($totalOrders) }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-neutral-100 p-6 flex flex-col justify-between shadow-xs">
                <div class="space-y-1">
                    <span class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider block">Total Revenue</span>
                    <h3 class="text-3xl font-light text-neutral-900 tracking-tight">₦{{ number_format($totalRevenue) }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-neutral-100 p-6 flex flex-col justify-between shadow-xs">
                <div class="space-y-1">
                    <span class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider block">Pending Orders</span>
                    <h3 class="text-3xl font-light text-neutral-900 tracking-tight">{{ number_format($pendingOrders) }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-neutral-100 p-6 flex flex-col justify-between shadow-xs">
                <div class="space-y-1">
                    <span class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider block">Average Order Value</span>
                    <h3 class="text-3xl font-light text-neutral-900 tracking-tight">₦{{ number_format($avgOrderValue) }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-neutral-100 shadow-xs overflow-hidden">
            @if($orders->count() > 0)
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full border-collapse text-left">
                        <thead>
                        <tr class="bg-neutral-50/70 border-b border-neutral-100 text-[10px] font-bold uppercase tracking-widest text-neutral-400">
                            <th class="px-6 py-4.5 font-semibold">Order Number</th>
                            <th class="px-6 py-4.5 font-semibold">Date</th>
                            <th class="px-6 py-4.5 font-semibold">Customer Details</th>
                            <th class="px-6 py-4.5 font-semibold">Order Status</th>
                            <th class="px-6 py-4.5 font-semibold">Payment Status</th>
                            <th class="px-6 py-4.5 font-semibold text-right">Total Price</th>
                            <th class="px-6 py-4.5 text-right"></th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100 text-xs text-neutral-700">
                        @foreach($orders as $order)
                            <tr class="hover:bg-neutral-50/40 transition-colors group" wire:key="desktop-row-{{ $order->id }}">
                                <td class="px-6 py-5 font-mono font-medium text-neutral-900">
                                    #{{ $order->order_number }}
                                </td>
                                <td class="px-6 py-5 text-neutral-400 font-light">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-5">
                                    <div class="space-y-0.5">
                                        <p class="font-medium text-neutral-800">{{ $order->customer_name }}</p>
                                        <p class="text-[11px] text-neutral-400 font-light">{{ $order->customer_email }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-amber-50 text-amber-700 border-amber-200/60',
                                            'processing' => 'bg-blue-50 text-blue-700 border-blue-200/60',
                                            'shipped' => 'bg-indigo-50 text-indigo-700 border-indigo-200/60',
                                            'delivered' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
                                            'cancelled' => 'bg-neutral-50 text-neutral-600 border-neutral-200',
                                        ];
                                        $badgeClass = $statusColors[$order->status] ?? 'bg-neutral-50 text-neutral-600 border-neutral-200';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold tracking-wider uppercase rounded-md border {{ $badgeClass }}">
                                            {{ $order->status }}
                                        </span>
                                </td>
                                <td class="px-6 py-5">
                                        <span class="inline-flex items-center gap-1.5 font-medium {{ $order->payment_status === 'paid' ? 'text-emerald-600' : 'text-neutral-400' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $order->payment_status === 'paid' ? 'bg-emerald-500' : 'bg-neutral-300' }}"></span>
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                </td>
                                <td class="px-6 py-5 text-right font-semibold text-neutral-900">
                                    ₦{{ number_format($order->total) }}
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <button
                                        type="button"
                                        wire:click="viewOrder({{ $order->id }})"
                                        class="bg-neutral-50 hover:bg-neutral-950 text-neutral-700 hover:text-white px-3 py-1.5 rounded-lg border border-neutral-200 hover:border-neutral-950 text-[11px] font-medium transition-all cursor-pointer"
                                    >
                                        View Details
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="block md:hidden divide-y divide-neutral-100">
                    @foreach($orders as $order)
                        <div class="p-4 space-y-4" wire:key="mobile-row-{{ $order->id }}">
                            <div class="flex items-start justify-between">
                                <div class="space-y-1">
                                    <span class="font-mono text-xs font-bold text-neutral-900">#{{ $order->order_number }}</span>
                                    <span class="block text-[11px] text-neutral-400 font-light">{{ $order->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="text-right font-semibold text-neutral-900 text-sm">
                                    ₦{{ number_format($order->total) }}
                                </div>
                            </div>

                            <div class="flex items-center justify-between text-xs">
                                <div>
                                    <p class="font-medium text-neutral-800 mb-0.5">{{ $order->customer_name }}</p>
                                    <span class="text-neutral-400 font-light">{{ $order->customer_phone }}</span>
                                </div>
                                <div class="flex flex-col items-end gap-1.5">
                                    <span class="inline-flex items-center px-2 py-0.5 text-[9px] font-bold tracking-wider uppercase rounded-md border {{ $statusColors[$order->status] ?? 'bg-neutral-50 border-neutral-200' }}">
                                        {{ $order->status }}
                                    </span>
                                    <span class="text-[11px] font-medium {{ $order->payment_status === 'paid' ? 'text-emerald-600' : 'text-neutral-400' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                            </div>

                            <button
                                type="button"
                                wire:click="viewOrder({{ $order->id }})"
                                class="w-full bg-neutral-50 text-neutral-700 py-2.5 rounded-xl border border-neutral-200 text-xs font-semibold text-center block cursor-pointer"
                            >
                                View Order Items
                            </button>
                        </div>
                    @endforeach
                </div>

                @if($orders->hasPages())
                    <div class="mt-6 px-6 py-4">
                        <flux:pagination :paginator="$orders" />
                    </div>
                @endif
            @else
                <div class="text-center py-20 max-w-xs mx-auto space-y-4">
                    <div class="w-14 h-14 bg-neutral-50 rounded-full flex items-center justify-center mx-auto border border-neutral-100 text-neutral-300">
                        <i class="fa-solid fa-folder-open text-lg"></i>
                    </div>
                    <h3 class="text-base font-medium text-neutral-900">No orders found</h3>
                    <p class="text-xs text-neutral-400 font-light leading-relaxed">
                        There are currently no orders saved in the system.
                    </p>
                </div>
            @endif
        </div>
    </div>

    @if($showOrderModal && $selectedOrder)
        <div class="fixed inset-0 z-50 flex justify-end" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-neutral-950/30 backdrop-blur-xs transition-opacity duration-300" wire:click="closeOrderModal"></div>

            <div
                class="relative w-full max-w-md bg-white h-full shadow-2xl flex flex-col justify-between border-l border-neutral-100/70 z-10 overflow-hidden"
                x-data
                x-transition:enter="transform transition ease-out duration-300"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in duration-200"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
            >
                <div class="p-6 border-b border-neutral-100 flex items-center justify-between bg-neutral-50/60">
                    <div>
                        <span class="text-[10px] font-mono text-neutral-400 block font-bold">ORDER INVOICE</span>
                        <h2 class="text-lg font-medium text-neutral-900 tracking-tight serif-display">Order #{{ $selectedOrder->order_number }}</h2>
                    </div>
                    <button
                        type="button"
                        wire:click="closeOrderModal"
                        class="w-8 h-8 rounded-full border border-neutral-200 text-neutral-400 hover:text-neutral-900 bg-white flex items-center justify-center transition-all cursor-pointer"
                    >
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </button>
                </div>

                <div class="p-6 flex-1 overflow-y-auto space-y-6 text-xs text-neutral-700">

                    <div class="space-y-3">
                        <h4 class="text-[10px] uppercase font-bold tracking-wider text-neutral-400">Customer Details</h4>
                        <div class="bg-neutral-50/70 border border-neutral-100 rounded-xl p-4 space-y-2">
                            <div class="flex justify-between"><span class="text-neutral-400 font-light">Name:</span><span class="font-medium text-neutral-900">{{ $selectedOrder->customer_name }}</span></div>
                            <div class="flex justify-between"><span class="text-neutral-400 font-light">Email:</span><span class="font-medium text-neutral-900 font-mono">{{ $selectedOrder->customer_email }}</span></div>
                            <div class="flex justify-between"><span class="text-neutral-400 font-light">Phone:</span><span class="font-medium text-neutral-900">{{ $selectedOrder->customer_phone }}</span></div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <h4 class="text-[10px] uppercase font-bold tracking-wider text-neutral-400">Items Purchased</h4>
                        <div class="space-y-3">
                            @foreach($selectedOrder->items as $item)
                                <div class="bg-white rounded-xl border border-neutral-100 p-4 shadow-2xs flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

                                    <div class="flex items-center gap-4 min-w-0 flex-1">

                                        <div class="w-16 h-20 bg-neutral-50 rounded-xl overflow-hidden shrink-0 border border-neutral-100 p-1.5 flex items-center justify-center bg-neutral-50/60">
                                            @if($item->product && $item->product->images->count() > 0)
                                                <img
                                                    src="{{ $item->product->primary_image_url }}"
                                                    alt="{{ $item->product_name }}"
                                                    class="w-full h-full object-contain mix-blend-multiply"
                                                >
                                            @else
                                                <span class="text-neutral-400 text-[10px] font-bold uppercase tracking-wider">
                                                    {{ substr($item->product_name, 0, 2) }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="space-y-1 min-w-0 flex-1">
                                            <h5 class="font-medium text-neutral-800 text-xs sm:text-sm truncate">
                                                {{ $item->product_name }}
                                            </h5>

                                            <div class="flex flex-wrap items-center gap-2 text-[11px] text-neutral-400 font-light">
                                                <span>Qty: <strong class="text-neutral-700 font-medium">{{ $item->quantity }}</strong></span>
                                                <span>•</span>
                                                <span>Unit Price: <strong class="text-neutral-700 font-medium">₦{{ number_format($item->unit_price) }}</strong></span>
                                            </div>

                                            @if($item->sku)
                                                <div class="pt-0.5">
                                                    <span class="inline-block text-[9px] text-neutral-400 bg-neutral-50 border border-neutral-200/60 px-1.5 py-0.5 rounded font-mono">
                                                        SKU: {{ $item->sku }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="text-left sm:text-right pt-2 sm:pt-0 border-t sm:border-t-0 border-neutral-50 shrink-0 flex sm:flex-col justify-between items-center sm:items-end">
                                        <span class="text-[10px] text-neutral-400 font-light block sm:hidden">Subtotal:</span>
                                        <span class="font-semibold text-neutral-900 text-sm">₦{{ number_format($item->total) }}</span>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-neutral-100 bg-neutral-50/80 space-y-1.5">
                    <div class="flex justify-between items-baseline">
                        <span class="text-xs font-medium text-neutral-400 uppercase tracking-wider">Total Due</span>
                        <span class="text-xl font-semibold text-neutral-900">₦{{ number_format($selectedOrder->total) }}</span>
                    </div>
                </div>

            </div>
        </div>
    @endif
</div>
