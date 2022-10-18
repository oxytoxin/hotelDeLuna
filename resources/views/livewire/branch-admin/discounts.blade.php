<div>
    <div>
        <x-table :headers="['Name', 'Description', 'Discount', 'Status', '']">
            <x-slot:topLeft>
                <x-input icon="search"
                    wire:model.debounce="search"
                    placeholder="Search..." />
            </x-slot:topLeft>
            <x-slot:topRight>
                <x-button label="Add Discount"
                    wire:click="add"
                    emerald />
            </x-slot:topRight>
            @forelse ($discounts as $discount)
                <x-table-row>
                    <x-table-data>
                        {{ $discount->name }}
                    </x-table-data>
                    <x-table-data>
                        {{ $discount->description }}
                    </x-table-data>
                    <x-table-data>
                        @if ($discount->is_percentage == false)
                            ₱
                            @endif {{ $discount->amount }} @if ($discount->is_percentage)
                                %
                            @endif
                    </x-table-data>
                    <x-table-data>
                        @if ($discount->is_available)
                            <span class="text-green-500">Available</span>
                        @else
                            <span class="text-red-500">Not Available</span>
                        @endif
                    </x-table-data>
                    <x-table-data>
                        <div class="flex justify-end px-2">
                            <div class="flex justify-end px-2">
                                <x-actions.edit wire:key="{{ $discount->id }}"
                                    wire:click="edit({{ $discount->id }})"
                                    wire:loading.class="cursor-progress"
                                    wire:loading.attr="disabled"
                                    wire:target="edit({{ $discount->id }})" />
                            </div>
                        </div>
                    </x-table-data>
                </x-table-row>
            @empty
                <x-table-empty rows="5" />
            @endforelse
            <x-slot:pagination>
                {{ $discounts->links() }}
            </x-slot:pagination>
        </x-table>
    </div>
    <div wire:key="modal-panel">
        <x-modal.card wire:model.defer="showModal"
            title="{{ $this->getModalTitle() }}">
            <form>
                @csrf
                <div class="gap-3 sm:grid sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <x-input label="Name"
                            wire:model.defer="name"
                            placeholder="Name" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-textarea label="Description"
                            wire:model.defer="description"
                            placeholder="Description"></x-textarea>
                    </div>
                    <x-native-select label="Type"
                        wire:model="type">
                        <option value="percentage">% Percentage</option>
                        <option value="amount"> ₱ Amount</option>
                    </x-native-select>
                    <x-input label="{{ $this->amountLabel() }}"
                        wire:model.defer="amount"
                        type="number"
                        placeholder="{{ $this->amountLabel() }}" />
                    <x-checkbox label="Available"
                        wire:model.defer="is_available" />
                </div>
            </form>
            <x-slot:footer>
                <x-button label="Save"
                    wire:click="save"
                    spinner="save"
                    primary />
            </x-slot:footer>
        </x-modal.card>
    </div>
</div>
