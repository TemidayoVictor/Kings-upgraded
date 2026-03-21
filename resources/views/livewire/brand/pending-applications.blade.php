
<section class="w-full">
    @include('partials.products-settings-heading')
    <x-brands.dropshippers :heading="__('Pending Applications')" :subheading="__('Manage Dropshippers Applications')">
        <flux:heading class="sr-only">{{ __('Pending Applications') }}</flux:heading>
        <div class="flex justify-end mb-4">
            <flux:button href="{{ route('brand-approved-dropshippers') }}" size="sm" variant="primary">
                View Dropshippers
            </flux:button>
        </div>

        <flux:separator/>

        <div class="min-h-screen mt-4">
            <div class="max-w-7xl mx-auto">
                <!-- Applications List -->
                <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">
                    @if($applications->count() > 0)
                        <!-- Desktop Table View (hidden on mobile) -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-500">
                                <thead class="bg-[#3d3d40]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        <button wire:click="sortBy('dropshipper')" class="flex items-center space-x-1 hover:text-gray-200">
                                            <span>DROPSHIPPER</span>
                                            @if($sortField === 'dropshipper')
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
                                        <button wire:click="sortBy('applied_date')" class="flex items-center space-x-1 hover:text-gray-200">
                                            <span>APPLIED</span>
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
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Notes
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
                                                <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center overflow-hidden">
                                                    @if($application->dropshipper->image)
                                                        <img src="{{ Storage::url($application->dropshipper->image) }}"
                                                             alt="{{ $application->dropshipper->user->name }}"
                                                             class="h-full w-full object-cover">
                                                    @else
                                                        <span class="text-gray-300 font-medium text-lg">
                                                                {{ substr($application->dropshipper->user->name, 0, 1) }}
                                                            </span>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-200">
                                                        {{ $application->dropshipper->user->name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $application->dropshipper->username }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                            {{ $application->created_at->format('M d, Y') }}
                                            <div class="text-xs text-gray-500">
                                                {{ $application->created_at->diffForHumans() }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 max-w-xs">
                                            @if($application->notes)
                                                <p class="text-sm text-gray-400 truncate">{{ $application->notes }}</p>
                                            @else
                                                <span class="text-sm text-gray-600">—</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                <flux:button wire:click="viewApplication({{ $application->id }})"
                                                             size="xs"
                                                             variant="primary">
                                                    Review
                                                </flux:button>

                                                <flux:button wire:click="quickReject({{ $application->id }})"
                                                             size="xs"
                                                             variant="danger">
                                                    Reject
                                                </flux:button>
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
                                            <div class="flex-shrink-0 h-12 w-12 bg-[#27272a] rounded-full flex items-center justify-center overflow-hidden">
                                                @if($application->dropshipper->image)
                                                    <img src="{{ Storage::url($application->dropshipper->image) }}"
                                                         alt="{{ $application->dropshipper->user->name }}"
                                                         class="h-full w-full object-cover">
                                                @else
                                                    <span class="text-gray-300 font-medium text-lg">
                                                        {{ substr($application->dropshipper->user->name, 0, 1) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-200">{{ $application->dropshipper->user->name }}</div>
                                                <div class="text-xs text-gray-500">@ {{ $application->dropshipper->username }}</div>
                                            </div>
                                        </div>

                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                                Pending
                                            </span>
                                        </div>
                                    </div>

                                    <div class="bg-[#27272a] rounded-lg p-3 mb-3">
                                        @if($application->notes)
                                            <div class="text-sm text-gray-400">
                                                <span class="text-xs text-gray-500 block mb-1 ">Notes:</span>
                                                <p class="truncate">"{{ $application->notes }}" </p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex space-x-2">
                                        <flux:button wire:click="viewApplication({{ $application->id }})"
                                                     class="flex-1 justify-center"
                                                     size="sm"
                                                     variant="primary">
                                            Review
                                        </flux:button>

                                        <flux:button wire:click="quickReject({{ $application->id }})"
                                                     class="flex-1 justify-center"
                                                     size="sm"
                                                     variant="danger">
                                            Reject
                                        </flux:button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 px-4">
                            <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-300">No pending applications</h3>
                            <p class="mt-1 text-sm text-gray-500">All caught up! No applications need review at the moment.</p>
                        </div>
                    @endif
                </div>

                @if($applications->hasPages())
                    <div class="mt-6">
                        {{ $applications->links() }}
                    </div>
                @endif

                <!-- Review Application Modal -->
                @if($showReviewModal)
                    <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4" style="z-index: 50;">
                        <div class="bg-[#27272a] rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                            <!-- Modal Header -->
                            <div class="px-6 py-4 border-b border-gray-600 flex items-center justify-between">
                                <h3 class="text-lg font-medium text-white">Review Application</h3>
                                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Modal Body -->
                            <div class="p-6 space-y-6">
                                @if($selectedApplication)
                                    <!-- Dropshipper Info -->
                                    <div class="bg-[#3d3d40] rounded-lg p-4">
                                        <h4 class="text-sm font-medium text-gray-400 mb-3">Dropshipper Information</h4>
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 h-16 w-16 bg-[#27272a] rounded-full flex items-center justify-center overflow-hidden">
                                                @if($selectedApplication->dropshipper->image)
                                                    <img src="{{ Storage::url($selectedApplication->dropshipper->image) }}"
                                                         alt="{{ $selectedApplication->dropshipper->user->name }}"
                                                         class="h-full w-full object-cover">
                                                @else
                                                    <span class="text-gray-300 font-medium text-2xl">
                                                        {{ substr($selectedApplication->dropshipper->user->name, 0, 1) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-lg font-medium text-white">{{ $selectedApplication->dropshipper->user->name }}</div>
                                                <div class="text-sm text-gray-400">Username: {{ $selectedApplication->dropshipper->username }}</div>
                                                <div class="text-sm text-gray-400">Email: {{ $selectedApplication->dropshipper->user->email }}</div>
                                                @if($selectedApplication->dropshipper->account_name)
                                                    <div class="text-sm text-gray-400 mt-2">
                                                        Bank: {{ $selectedApplication->dropshipper->bank_name }} |
                                                        Account: {{ $selectedApplication->dropshipper->account_name }} ({{ $selectedApplication->dropshipper->account_number }})
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Application Notes -->
                                    @if($selectedApplication->notes)
                                        <div class="bg-[#3d3d40] rounded-lg p-4">
                                            <h4 class="text-sm font-medium text-gray-400 mb-2">Applicant's Notes</h4>
                                            <p class="text-gray-300 bg-[#27272a] p-3 rounded-lg text-[.9rem]">{{ $selectedApplication->notes }}</p>
                                        </div>
                                    @endif

                                    <!-- Review Form -->
                                    <div class="bg-[#3d3d40] rounded-lg p-4">
                                        <h4 class="text-sm font-medium text-gray-400 mb-3">Your Decision</h4>

                                        <div class="space-y-4">
                                            <div>
                                                <flux:label>Feedback / Notes (Optional for approval, required for rejection)</flux:label>
                                                <textarea
                                                    wire:model.defer="reviewNotes"
                                                    rows="4"
                                                    class="w-full rounded-md border-gray-600 bg-[#27272a] text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 text-[.9rem] p-2 mt-2"
                                                    placeholder="Provide feedback to the dropshipper..."
                                                ></textarea>
                                                <flux:error name="reviewNotes" />
                                            </div>

                                            @if($selectedApplication->status === 'pending')
                                                <div class="flex items-center space-x-2 text-sm text-gray-400">
                                                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span>Application submitted {{ $selectedApplication->created_at->diffForHumans() }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Modal Footer -->
                            <div class="px-6 py-4 border-t border-gray-600 flex justify-end space-x-3">
                                <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                    Cancel
                                </flux:button>

                                <flux:button type="button"
                                             variant="danger"
                                             wire:click="rejectApplication"
                                             size="sm"
                                             wire:loading.attr="disabled">
                                    <flux:icon.loading wire:loading wire:target="rejectApplication" />
                                    <span wire:loading.remove wire:target="rejectApplication">Reject Application</span>
                                </flux:button>

                                <flux:button type="button"
                                             variant="primary"
                                             size="sm"
                                             wire:click="approveApplication"
                                             wire:loading.attr="disabled">
                                    <flux:icon.loading wire:loading wire:target="approveApplication" />
                                    <span wire:loading.remove wire:target="approveApplication">Approve Application</span>
                                </flux:button>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Quick Reject Modal -->
                @if($showQuickRejectModal)
                    <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4" style="z-index: 50;">
                        <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                            <h3 class="text-lg font-medium text-white mb-4">Reject Application</h3>

                            <form wire:submit="submitQuickReject">
                                <div class="space-y-4">
                                    <div>
                                        <flux:label>Reason for rejection <span class="text-red-400">*</span></flux:label>
                                        <textarea
                                            wire:model.defer="rejectReason"
                                            rows="3"
                                            class="w-full rounded-md border-gray-600 bg-[#3d3d40] text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 text-[.9rem] p-2 mt-3"
                                            placeholder="Please provide feedback to the dropshipper..."
                                            required
                                        ></textarea>
                                        <flux:error name="rejectReason" />
                                    </div>

                                    <div class="flex justify-end space-x-2">
                                        <flux:button type="button" variant="subtle" wire:click="closeModal" size="sm">
                                            Cancel
                                        </flux:button>
                                        <flux:button type="submit" variant="danger" size="sm">
                                            <flux:icon.loading wire:loading wire:target="submitQuickReject" />
                                            <span wire:loading.remove wire:target="submitQuickReject">Confirm Rejection</span>
                                        </flux:button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </x-brands.dropshippers>
</section>
