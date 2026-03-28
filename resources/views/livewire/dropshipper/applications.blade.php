<section class="w-full">
    @include('partials.partnerships')

    <flux:heading class="sr-only">{{ __('Brand Applications') }}</flux:heading>

    <x-dropshippers.layout :heading="__('Brand Applications')" :subheading="__('List of Applications to Brands')">
        <div class="flex justify-end mb-4">
            <flux:button href=" {{ route('dropshipper-browse-brands')  }} " size="sm" variant="primary">
                Browse Brands
            </flux:button>
        </div>

        <flux:separator/>

        <div class="min-h-screen">
            <div class="max-w-7xl mx-auto">
                <!-- Header with Filters -->
                <div class="flex flex-col gap-4 my-3">
                    <flux:heading class="sr-only">{{ __('Applications List') }}</flux:heading>

                    <!-- Status Filter -->
                    <div class="flex items-center space-x-2">
                        <flux:select wire:model.live="statusFilter" class="w-40">
                            <option value="all">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </flux:select>

                        <flux:input type="search"
                                    wire:model.live.debounce.300ms="search"
                                    placeholder="Search brands..."
                                    class="w-64" />
                    </div>
                </div>

                <!-- Applications List -->
                <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">
                    @if($applications->count() > 0)
                        <!-- Desktop Table View (hidden on mobile) -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-500">
                                <thead class="bg-[#3d3d40]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        <button wire:click="sortBy('brand_name')" class="flex items-center space-x-1 hover:text-gray-200">
                                            <span>BRAND</span>
                                            @if($sortField === 'brand_name')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if($sortDirection === 'asc')
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    @endif
                                                </svg>
                                            @endif
                                        </button>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        <button wire:click="sortBy('applied_date')" class="flex items-center space-x-1 hover:text-gray-200">
                                            <span>DATE</span>
                                            @if($sortField === 'applied_date')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if($sortDirection === 'asc')
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    @endif
                                                </svg>
                                            @endif
                                        </button>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-[#3d3d40] divide-y divide-gray-500">
                                @foreach($applications as $application)
                                    <tr class="hover:bg-gray-750 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-lg flex items-center justify-center overflow-hidden">
                                                    @if($application->brand->image)
                                                        <img src="{{ Storage::url($application->brand->image) }}"
                                                             alt="{{ $application->brand->brand_name }}"
                                                             class="h-full w-full object-cover">
                                                    @else
                                                        <span class="text-gray-300 font-medium text-lg">
                                                                {{ substr($application->brand->brand_name, 0, 1) }}
                                                            </span>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-200">
                                                        {{ $application->brand->brand_name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        by {{ $application->brand->user->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($application->status === 'pending')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                                        Pending Review
                                                    </span>
                                            @elseif($application->status === 'approved')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                                        Approved
                                                    </span>
                                            @elseif($application->status === 'rejected')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-500/20 text-red-400 border border-red-500/30">
                                                        Rejected
                                                    </span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                            {{ $application->created_at->format('M d, Y') }}
                                            <div class="text-xs text-gray-500">
                                                {{ $application->created_at->diffForHumans() }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-3">
                                                @if($application->status === 'approved')
                                                    <a href="{{ route('dropshipper-create-store', $application->brand) }}"
                                                       class="text-green-400 hover:text-green-300 transition-colors"
                                                       title="Create Store">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                    </a>
                                                @endif

                                                @if($application->notes)
                                                    <button
                                                        wire:click="viewNotes({{ $application->id }})"
                                                        class="text-gray-400 hover:text-gray-200 transition-colors"
                                                        title="View Notes"
                                                    >
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                        </svg>
                                                    </button>
                                                @endif

                                                @if($application->status === 'rejected' && $application->reviewed_at)
                                                    <button
                                                        wire:click="viewFeedback({{ $application->id }})"
                                                        class="text-gray-400 hover:text-gray-200 transition-colors"
                                                        title="View Feedback"
                                                    >
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View (visible only on mobile) -->
                        <div class="sm:hidden divide-y divide-gray-500">
                            @foreach($applications as $application)
                                <div class="p-4 hover:bg-gray-750 transition-colors">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0 h-12 w-12 bg-[#27272a] rounded-lg flex items-center justify-center overflow-hidden">
                                                @if($application->brand->image)
                                                    <img src="{{ Storage::url($application->brand->image) }}"
                                                         alt="{{ $application->brand->brand_name }}"
                                                         class="h-full w-full object-cover">
                                                @else
                                                    <span class="text-gray-300 font-medium text-lg">
                                                        {{ substr($application->brand->brand_name, 0, 1) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-200">{{ $application->brand->brand_name }}</div>
                                                <div class="text-xs text-gray-500">by {{ $application->brand->user->name }}</div>
                                            </div>
                                        </div>

                                        @if($application->status === App\Enums\Status::PENDING)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                                Pending
                                            </span>
                                        @elseif($application->status === App\Enums\Status::APPROVED)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                                Approved
                                            </span>
                                        @elseif($application->status === App\Enums\Status::REJECTED)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-500/20 text-red-400 border border-red-500/30">
                                                Rejected
                                            </span>
                                        @endif
                                    </div>

                                    <div class="flex items-center justify-between mt-2">
                                        <div class="text-xs text-gray-500">
                                            Applied: {{ $application->created_at->format('M d, Y') }}
                                        </div>

                                        <div class="flex items-center space-x-2">
                                            @if($application->status === 'approved')
                                                <a href="{{ route('dropshipper-create-store', $application->brand) }}"
                                                   class="p-2 text-green-400 hover:text-green-300 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    </svg>
                                                </a>
                                            @endif

                                            @if($application->notes)
                                                <button wire:click="viewNotes({{ $application->id }})" class="p-2 text-gray-400 hover:text-gray-200">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 px-4">
                            <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-300">No applications yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Start by applying to some brands.</p>
                            <div class="mt-6">
                                <flux:button href="" variant="primary">
                                    Browse Brands
                                </flux:button>
                            </div>
                        </div>
                    @endif
                </div>

                @if($applications->hasPages())
                    <div class="mt-6">
                        <flux:pagination :paginator="$applications" />
                    </div>
                @endif

                <!-- Notes Modal -->
                @if($showNotesModal)
                    <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4" style="z-index: 50;">
                        <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                            <h3 class="text-lg font-medium text-white mb-4">Application Notes</h3>
                            <div class="bg-[#3d3d40] rounded-lg p-4 mb-4">
                                <p class="text-gray-300 whitespace-pre-wrap text-[.9rem]">{{ $selectedNotes }}</p>
                            </div>
                            @if($this->selectedStatus == App\Enums\Status::REJECTED)
                                <div class="my-2">
                                    <label class="block text-sm font-medium text-gray-300 mb-2">
                                        Re-apply to Brand
                                    </label>
                                    <textarea
                                        wire:model="note"
                                        rows="4"
                                        class="w-full rounded-md border-gray-600 bg-[#3d3d40] text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 text-[.9rem] p-2"
                                        placeholder="Tell the brand owner why you'd like to dropship their products..."
                                    ></textarea>
                                </div>
                            @endif
                            <div class="flex justify-end gap-2">
                                <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                    Close
                                </flux:button>
                                @if($this->selectedStatus == App\Enums\Status::REJECTED)
                                    <flux:button type="button" variant="primary" size="sm" wire:click="reapply">
                                        Re-apply
                                    </flux:button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Feedback Modal (for rejected applications) -->
                @if($showFeedbackModal)
                    <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4" style="z-index: 50;">
                        <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                            <h3 class="text-lg font-medium text-white mb-4">Application Feedback</h3>
                            <div class="bg-[#3d3d40] rounded-lg p-4 mb-4">
                                <p class="text-gray-300 whitespace-pre-wrap text-[.9rem]">{{ $selectedFeedback }}</p>
                                @if($selectedReviewedAt)
                                    <p class="text-xs text-gray-500 mt-2">Reviewed: {{ $selectedReviewedAt->format('M d, Y') }}</p>
                                @endif
                            </div>
                            @if($this->selectedStatus == App\Enums\Status::REJECTED)
                                <div class="my-2">
                                    <label class="block text-sm font-medium text-gray-300 mb-2">
                                        Re-apply to Brand
                                    </label>
                                    <textarea
                                        wire:model="note"
                                        rows="4"
                                        class="w-full rounded-md border-gray-600 bg-[#3d3d40] text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 text-[.9rem] p-2"
                                        placeholder="Tell the brand owner why you'd like to dropship their products..."
                                    ></textarea>
                                </div>
                            @endif
                            <div class="flex justify-end gap-2">
                                <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                    Close
                                </flux:button>
                                @if($this->selectedStatus == App\Enums\Status::REJECTED)
                                    <flux:button type="button" variant="primary" size="sm" wire:click="reapply">
                                        Re-apply
                                    </flux:button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </x-dropshippers.layout>
</section>
