<div>
    <div>
    </div>
    {{-- @if (auth()->user()->branch->extension_capping)
        <x-card shadow="shadow"
            title="Extend Hours"
            cardClasses="border-gray-300 border">
            <form class="sm:grid sm:grid-cols-2 gap-4">
                @csrf
                <div class="sm:col-span-1">
                    <x-native-select label="Select Hours"
                        wire:model="form.extension_id">
                        <option value="">Select</option>
                        @forelse ($available_hours_for_extension_with_in_this_branch as $extension)
                            <option value="{{ $extension->id }}"
                                @disabled($extension->hours + $total_extension_hours > $branch_extension_resetting_time)>
                                {{ $extension->hours }}
                                {{ Str::plural('Hour', $extension->hours) }} --
                                ₱{{ $extension->amount }}
                            </option>
                        @empty
                            <option value=""
                                disabled>No Available Hours</option>
                        @endforelse
                    </x-native-select>
                </div>
            </form>
            <x-slot:footer>
                <div class="flex space-x-3 items-center">
                    <x-button>Cancel</x-button>
                    <x-button primary>Save</x-button>
                </div>
            </x-slot:footer>
        </x-card>
    @else
        <div class="rounded-md bg-yellow-50 p-4 border-yellow-400">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M8.485 3.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 3.495zM10 6a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 6zm0 9a1 1 0 100-2 1 1 0 000 2z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Attention needed</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>
                            This branch has not yet set the extension resetting time. Kindly set this to your admin
                            account.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif --}}
</div>
