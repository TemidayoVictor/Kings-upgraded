<section class="w-full">
    @include('partials.orders-heading')

    <flux:heading class="sr-only">{{ __('Batched Orders') }}</flux:heading>
    <x-products.layout :heading="__('Batched Orders')" :subheading="__('Manage your orders')">
        <div class="min-h-screen">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 my-3">
                    <flux:heading class="sr-only">{{ __('Section List') }}</flux:heading>
                </div>

                <!-- Sections List -->
                <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">
                    @if($batches->count() > 0)
                        <!-- Desktop Table View (hidden on mobile) -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-500">
                                <thead class="bg-[#3d3d40]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        <span>Batch</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        <span>Orders</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-[#3d3d40] divide-y divide-gray-500">
                                @foreach($batches as $index => $batch)
                                    <tr class="hover:bg-gray-750 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 bg-[#27272a] rounded-full flex items-center justify-center">
                                                    <span class="text-gray-300 font-medium">{{ $index + 1 }}</span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-200">
                                                        {{ $batch->created_at->format('M d, Y') }}{{ '_'.$index+1 }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-[#27272a] text-gray-300">
                                                {{ $batch->orders ?? 0 }} Order{{ $batch->orders == 1 ? '' : 's' }}
                                            </span>
                                        </td>
                                        <td class="">
                                            <flux:button size="sm" href="{{ route('dropshipper-orders-batched', $batch) }}" variant="primary">
                                                View Orders
                                            </flux:button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View (visible only on mobile) -->
                        <div class="sm:hidden divide-y divide-gray-500">
                            @foreach($batches as $index => $batch)
                                <div class="p-4 hover:bg-gray-750 transition-colors">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">
                                                <span class="text-gray-300 font-medium">{{ $index + 1 }}</span>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-200">{{ $batch->created_at->format('M d, Y') }}{{'_'.$index+1}}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <flux:button size="sm" href="{{ route('dropshipper-orders-batched', $batch) }}" variant="primary">
                                                View Orders
                                            </flux:button>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between mt-3 pt-2 border-t border-dashed border-gray-500">
                                        <div class="flex items-center space-x-4">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-[#27272a] text-gray-300">
                                                {{ $batch->orders ?? 0 }} products
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 px-4">
                            <svg class="mx-auto h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-300">No sections</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new section.</p>
                        </div>
                    @endif
                </div>

                @if($batches->hasPages())
                    <div class="mt-6">
                        <flux:pagination :paginator="$batches" />
                    </div>
                @endif
            </div>
        </div>
    </x-products.layout>
</section>
