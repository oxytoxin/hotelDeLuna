<div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
    <dt class="text-sm font-medium text-gray-500">
        Extension Time Reset
    </dt>
    <dd class="flex mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
        <span class="flex-grow">
            {{ $extension_capping->hours ?? 'N/A' }}
            {{ $extension_capping ? Str::plural('hour', $extension_capping->hours ?? 0) : '' }}
        </span>
        <span class="flex-shrink-0 ml-4">
            @if ($extension_capping)
                <button wire:click="$set('showModal',true)"
                    type="button"
                    class="font-medium text-blue-600 bg-white rounded-md hover:text-blue-500 focus:outline-none ">
                    UPDATE
                </button>
            @else
                <button wire:click="$set('showModal',true)"
                    type="button"
                    class="font-medium text-green-600 bg-white rounded-md hover:text-green-500 focus:outline-none ">
                    SET
                </button>
            @endif
        </span>
    </dd>
    <x-modal.card wire:model.defer="showModal"
        title="Create Extension Resetting Time">
        <form>
            @csrf
            <x-input label="Hours"
                wire:model.defer="hours" />
        </form>
        <x-slot:footer>
            <x-button primary
                wire:click="save"
                spinner="save"
                label="Save" />
        </x-slot:footer>
    </x-modal.card>
</div>
