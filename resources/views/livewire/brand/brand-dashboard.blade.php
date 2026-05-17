<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    @include('partials.dashboard-heading')
    <!-- Stats Cards Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-[#3d3d40] rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-400 mb-1">Today's Revenue</p>
                    <p class="text-xl sm:text-2xl md:text-2xl text-white">₦{{ number_format($realTimeMetrics['today_revenue'] ?? 0, 2) }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-[#3d3d40] rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-400 mb-1">Today's Orders</p>
                    <p class="text-xl sm:text-2xl md:text-2xl text-white">{{ $realTimeMetrics['today_orders'] ?? 0 }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-[#3d3d40] rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-400 mb-1">Pending Payments</p>
                    <p class="text-xl sm:text-2xl md:text-2xl text-yellow-400">₦{{ number_format($realTimeMetrics['pending_payments'] ?? 0, 2) }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <a href="{{ route('brand-order-status', ['status' => App\Enums\Status::PENDING])  }}" class="bg-[#3d3d40] rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-400 mb-1">Undelivered Orders</p>
                    <p class="text-xl sm:text-2xl md:text-2xl text-red-400">{{ number_format($realTimeMetrics['undelivered_orders'] ?? 0) }} Orders</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-red-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </a>
    </div>

    <!-- Main Content Area - Chart + Revenue Summary -->
    <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-700 bg-[#3d3d40]">
        <div class="p-4 sm:p-6">
            <!-- Date Range Selector -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-white">Revenue Overview</h3>
                    <p class="text-xs text-gray-400 mt-1">Track your sales performance over time</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                    <select wire:model.live="dateRange" class="bg-[#2a2a2e] text-white rounded-lg border border-neutral-600 px-3 sm:px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500" wire:key="dateRange">
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="7days">Last 7 Days</option>
                        <option value="30days">Last 30 Days</option>
                        <option value="this_month">This Month</option>
                        <option value="last_month">Last Month</option>
                        <option value="this_year">This Year</option>
                        <option value="custom">Custom Range</option>
                    </select>

                    @if($dateRange === 'custom')
                        <div class="flex gap-2">
                            <input type="date" wire:model.live="startDate" class="bg-[#2a2a2e] text-white rounded-lg border border-neutral-600 px-3 py-2 text-sm">
                            <input type="date" wire:model.live="endDate" class="bg-[#2a2a2e] text-white rounded-lg border border-neutral-600 px-3 py-2 text-sm">
                        </div>
                    @endif
                </div>
            </div>

            <!-- Chart Container -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mb-4">
                    <div class="flex gap-2 w-full sm:w-auto">
                        <button onclick="switchChart('revenue')" class="flex-1 sm:flex-initial text-xs sm:text-sm px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 transition border border-blue-500/30">
                            Revenue Chart
                        </button>
                        <button onclick="switchChart('orders')" class="flex-1 sm:flex-initial text-xs sm:text-sm px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg bg-gray-500/20 text-gray-400 hover:bg-gray-500/30 transition border border-gray-500/30">
                            Orders Chart
                        </button>
                    </div>
                    <div class="text-xs text-gray-500">
                        <span class="inline-flex items-center">
                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-1"></span> Revenue
                        </span>
                        <span class="inline-flex items-center ml-3">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span> Paid Revenue
                        </span>
                    </div>
                </div>
                <div class="h-64 sm:h-80 md:h-96">
                    <canvas id="revenueChart" wire:ignore></canvas>
                </div>
            </div>

            <!-- Revenue Summary Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mt-6 pt-6 border-t border-gray-500">
                <div>
                    <p class="text-xs text-gray-400 mb-1">Gross Revenue</p>
                    <p class="text-lg sm:text-xl font-bold text-white">₦{{ number_format($dashboardData['summary']['gross_revenue'] ?? 0, 2) }}</p>
                    @if(isset($dashboardData['period_comparison']['growth']['revenue']))
                        <p class="text-xs {{ $dashboardData['period_comparison']['growth']['revenue'] >= 0 ? 'text-green-400' : 'text-red-400' }} mt-1">
                            {{ $dashboardData['period_comparison']['growth']['revenue'] >= 0 ? '↑' : '↓' }}
                            {{ abs($dashboardData['period_comparison']['growth']['revenue']) }}% vs previous
                        </p>
                    @endif
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Dropshipper's Gross Revenue</p>
                    <p class="text-lg sm:text-xl font-bold text-white">₦{{ number_format($dashboardData['summary']['dropshipper_gross_revenue'] ?? 0, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Total Orders</p>
                    <p class="text-lg sm:text-xl font-bold text-white">{{ number_format($dashboardData['summary']['total_orders'] ?? 0) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Total Discounts</p>
                    <p class="text-lg sm:text-xl font-bold text-white">₦{{ number_format($dashboardData['summary']['total_discounts'] ?? 0, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Last Hour Revenue</p>
                    <p class="text-lg sm:text-xl font-bold text-white">₦{{ number_format($realTimeMetrics['last_hour_revenue'] ?? 0, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Campaign Performance Section -->
    <div class="relative overflow-hidden rounded-xl border border-neutral-700 bg-[#3d3d40]">
        <div class="p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-white">Sales Campaign Performance</h3>
                    <p class="text-xs text-gray-400 mt-1">Track your active and past sales campaigns</p>
                </div>
                <a href="{{ route('brand-run-sales') }}" class="w-full sm:w-auto">
                    <flux:button size="sm" variant="primary" class="w-full sm:w-auto justify-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Campaign
                    </flux:button>
                </a>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                @if(count($dashboardData['sales_performance'] ?? []) > 0)
                    <table class="w-full">
                        <thead>
                        <tr class="border-b border-gray-500">
                            <th class="text-left py-3 text-xs font-medium text-gray-400">Campaign</th>
                            <th class="text-right py-3 text-xs font-medium text-gray-400">Items Sold</th>
                            <th class="text-right py-3 text-xs font-medium text-gray-400">Revenue</th>
                            <th class="text-right py-3 text-xs font-medium text-gray-400">Orders</th>
                            <th class="text-right py-3 text-xs font-medium text-gray-400">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dashboardData['sales_performance'] as $sale)
                            <tr class="border-b border-gray-500 hover:bg-neutral-800/50 transition-colors">
                                <td class="py-3">
                                    <div>
                                        <p class="text-sm font-medium text-white">{{ $sale->name }}</p>
                                        <p class="text-xs text-gray-500 mb-2">
                                            {{ ucfirst($sale->discount_type) }}:

                                            {{ $sale->discount_type == 'fixed' ? '₦' : '' }}

                                            {{ $sale->discount_value }}

                                            {{ $sale->discount_type == 'percentage' ? '%' : '' }}
                                        </p>
                                    </div>
                                </td>
                                <td class="text-right py-3 text-sm text-white">{{ number_format($sale->items_sold) }}</td>
                                <td class="text-right py-3 text-sm text-green-400">₦{{ number_format($sale->revenue_generated, 2) }}</td>
                                <td class="text-right py-3 text-sm text-white">{{ number_format($sale->orders_count) }}</td>
                                <td class="text-right py-3">
                                    @if($sale->ongoing)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400">
                                                <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1 animate-pulse"></span>
                                                Active
                                            </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-500/20 text-gray-400">
                                                Ended
                                            </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-400">No sales campaigns found</p>
                        <p class="text-xs text-gray-500 mt-1">Create your first sale campaign to track performance</p>
                    </div>
                @endif
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden space-y-3">
                @forelse($dashboardData['sales_performance'] ?? [] as $sale)
                    <div class="bg-[#2a2a2e] rounded-lg p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-medium text-white">{{ Str::limit($sale->name, 30) }}</h4>
                                    @if($sale->ongoing)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-400">
                                            <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1 animate-pulse"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-500/20 text-gray-400">
                                            Ended
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 mb-2">
                                    {{ ucfirst($sale->discount_type) }}:

                                    {{ $sale->discount_type == 'fixed' ? '₦' : '' }}

                                    {{ $sale->discount_value }}

                                    {{ $sale->discount_type == 'percentage' ? '%' : '' }}
                                </p>
                                <div class="grid grid-cols-2 gap-2 text-xs">
                                    <div>
                                        <span class="text-gray-500">Items Sold:</span>
                                        <span class="text-white ml-1">{{ number_format($sale->items_sold) }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Orders:</span>
                                        <span class="text-white ml-1">{{ number_format($sale->orders_count) }}</span>
                                    </div>
                                    <div class="col-span-2">
                                        <span class="text-gray-500">Revenue:</span>
                                        <span class="text-green-400 ml-1">₦{{ number_format($sale->revenue_generated, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="mx-auto h-10 w-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-400">No sales campaigns</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Top Selling Products Section -->
    <div class="relative overflow-hidden rounded-xl border border-neutral-700 bg-[#3d3d40]">
        <div class="p-4 sm:p-6">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-white">Top Selling Products</h3>
                <p class="text-xs text-gray-400 mt-1">Best performing products by revenue</p>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                @if(count($dashboardData['top_products'] ?? []) > 0)
                    <table class="w-full">
                        <thead>
                        <tr class="border-b border-gray-500">
                            <th class="text-left py-3 text-xs font-medium text-gray-400">Product</th>
                            <th class="text-right py-3 text-xs font-medium text-gray-400">Units Sold</th>
                            <th class="text-right py-3 text-xs font-medium text-gray-400">Orders</th>
                            <th class="text-right py-3 text-xs font-medium text-gray-400">Revenue</th>
                            <th class="text-right py-3 text-xs font-medium text-gray-400">Avg Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dashboardData['top_products'] as $product)
                            <tr class="border-b border-gray-500 hover:bg-neutral-800/50 transition-colors">
                                <td class="py-3">
                                    <div class="flex items-center gap-3">
                                        @if($product->product->images->count() > 0)
                                            <img src="{{ $product->product->primary_image_url }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-10 h-10 object-cover rounded-full">
                                        @else
                                            <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">
                                                <span class="text-gray-300 font-medium">{{ substr($product->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-medium text-white">{{ Str::limit($product->product_name, 40) }}</p>
                                            <p class="text-xs text-gray-500">Price: ₦ {{ number_format($product->product->price) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-right py-3 text-sm text-white">{{ number_format($product->total_quantity) }}</td>
                                <td class="text-right py-3 text-sm text-white">{{ number_format($product->order_count) }}</td>
                                <td class="text-right py-3 text-sm text-green-400">₦{{ number_format($product->total_revenue, 2) }}</td>
                                <td class="text-right py-3 text-sm text-white">₦{{ number_format($product->average_price, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-400">No product data available</p>
                    </div>
                @endif
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden space-y-3">
                @forelse($dashboardData['top_products'] ?? [] as $product)
                    <div class="bg-[#2a2a2e] rounded-lg p-4">
                        <div class="flex items-start gap-3 mb-3">
                            @if($product->product->images->count() > 0)
                                <img src="{{ $product->product->primary_image_url }}"
                                     alt="{{ $product->name }}"
                                     class="w-10 h-10 object-cover rounded-full">
                            @else
                                <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">
                                    <span class="text-gray-300 font-medium">{{ substr($product->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-white truncate">{{ $product->product_name }}</h4>
                                <p class="text-xs text-gray-500">Price: ₦ {{ number_format($product->product->price) }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-xs text-gray-500">Units Sold</p>
                                <p class="text-white font-medium">{{ number_format($product->total_quantity) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Orders</p>
                                <p class="text-white font-medium">{{ number_format($product->order_count) }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-xs text-gray-500">Revenue</p>
                                <p class="text-green-400 font-medium">₦{{ number_format($product->total_revenue, 2) }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="mx-auto h-10 w-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-400">No products yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let revenueChart = null;

        document.addEventListener('livewire:initialized', function () {
            setTimeout(() => updateChart(), 100);

            Livewire.on('dataLoaded', () => {
                setTimeout(() => updateChart(), 100);
            });
        });

        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                if (revenueChart) {
                    revenueChart.resize();
                }
            }, 250);
        });

        function updateChart() {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            const dailyData = @json($dashboardData['daily_breakdown'] ?? []);

            if (revenueChart) {
                revenueChart.destroy();
            }

            if (!dailyData || dailyData.length === 0) {
                ctx.fillStyle = '#9ca3af';
                ctx.font = '14px sans-serif';
                ctx.textAlign = 'center';
                ctx.fillText('No data available', ctx.canvas.width / 2, ctx.canvas.height / 2);
                return;
            }

            revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dailyData.map(d => d.date),
                    datasets: [{
                        label: 'Revenue (₦)',
                        data: dailyData.map(d => d.revenue),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: 'rgb(59, 130, 246)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: window.innerWidth < 640 ? 2 : 4,
                        pointHoverRadius: window.innerWidth < 640 ? 4 : 6
                    }, {
                        label: 'Paid Revenue (₦)',
                        data: dailyData.map(d => d.paid_revenue || 0),
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: 'rgb(34, 197, 94)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: window.innerWidth < 640 ? 2 : 4,
                        pointHoverRadius: window.innerWidth < 640 ? 4 : 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                color: '#9ca3af',
                                usePointStyle: true,
                                boxWidth: 10,
                                font: {
                                    size: window.innerWidth < 640 ? 10 : 12
                                }
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += '₦' + context.parsed.y.toLocaleString();
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                color: 'rgba(75, 85, 99, 0.2)',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#9ca3af',
                                callback: function(value) {
                                    return '₦' + value.toLocaleString();
                                },
                                font: {
                                    size: window.innerWidth < 640 ? 10 : 12
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#9ca3af',
                                maxRotation: window.innerWidth < 640 ? 45 : 0,
                                minRotation: window.innerWidth < 640 ? 45 : 0,
                                font: {
                                    size: window.innerWidth < 640 ? 10 : 12
                                }
                            }
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    }
                }
            });
        }

        function switchChart(type) {
            const dailyData = @json($dashboardData['daily_breakdown'] ?? []);

            if (revenueChart) {
                if (type === 'orders') {
                    revenueChart.data.datasets = [{
                        label: 'Order Count',
                        data: dailyData.map(d => d.orders),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: 'rgb(59, 130, 246)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }];
                    revenueChart.options.scales.y.ticks.callback = function(value) {
                        return value.toLocaleString();
                    };
                } else {
                    revenueChart.data.datasets = [{
                        label: 'Revenue (₦)',
                        data: dailyData.map(d => d.revenue),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: 'rgb(59, 130, 246)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }, {
                        label: 'Paid Revenue (₦)',
                        data: dailyData.map(d => d.paid_revenue || 0),
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: 'rgb(34, 197, 94)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }];
                    revenueChart.options.scales.y.ticks.callback = function(value) {
                        return '₦' + value.toLocaleString();
                    };
                }
                revenueChart.update();
            }
        }
    </script>
@endpush
