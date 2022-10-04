<div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
    <dt class="text-sm font-medium text-gray-500">
        Admin Authorization Code
    </dt>
    <dd class="flex mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
        <span class="flex-grow">
            @if ($code)
                <span class="text-green-600">
                    ******
                </span>
            @else
                N/A
            @endif

        </span>
        <span class="flex-shrink-0 ml-4">
            @if ($code)
                <button wire:click="edit"
                    type="button"
                    class="font-medium text-blue-600 bg-white rounded-md hover:text-blue-500 focus:outline-none ">
                    UPDATE
                </button>
            @else
                <button wire:click="add"
                    type="button"
                    class="font-medium text-green-600 bg-white rounded-md hover:text-green-500 focus:outline-none ">
                    SET
                </button>
            @endif
        </span>
    </dd>
    <x-modal.card wire:model.defer="modal.show"
        title="{{ $modal['title'] }}">
        <form class="grid space-y-2">
            @csrf
            <x-input label="New Authorization Code"
                wire:model.defer="form.authorization_code" />
            <div>
                @if ($code)
                    <x-input label="Old Code"
                        wire:model.defer="form.old_code" />
                @endif
            </div>
        </form>
        <x-slot:footer>
            @if ($code)
                <x-button primary
                    wire:click="update"
                    spinner="update"
                    label="Update" />
            @else
                <x-button primary
                    wire:click="create"
                    spinner="create"
                    label="Save" />
            @endif
        </x-slot:footer>
    </x-modal.card>
</div>
