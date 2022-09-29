<div>
    <x-modal.card wire:model.defer="extendModal"
        title="Extent Check In Hour">
        <form>
            @csrf
            <div class="gap-3 sm:grid sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <x-native-select label="Extend Hour"
                        type="number"
                        wire:model.defer="extenstion_id">
                        <option value="">Select Hour</option>
                        @forelse ($extensions as $extension)
                            <option value="{{ $extension->id }}">
                                {{ $extension->hours }} {{ Str::plural('hrs', $extension->hours) }} -- &#8369;
                                {{ $extension->amount }}
                            </option>
                        @empty
                            <option value="">No record found</option>
                        @endforelse
                    </x-native-select>
                </div>
                <x-checkbox id="right-label"
                    wire:model.defer="extension_paid"
                    label="Paid" />
            </div>
        </form>
        <x-slot:footer>
            <x-button label="Extend"
                wire:click="saveExtend"
                spinner="saveExtend"
                primary />
        </x-slot:footer>
    </x-modal.card>
</div>
