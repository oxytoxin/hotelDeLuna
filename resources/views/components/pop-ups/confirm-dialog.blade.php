<div x-data="{
    show: false,
    title: '',
    message: '',
    confirmButtonText: '',
    cancelButtonText: '',
    confirmMethod: null,
    cancelMethod: null,
    confirmParams: null,
    cancelParams: null,
    confirm() {
        this.show = false;
        if (this.confirmMethod) {
            Livewire.emit(this.confirmMethod, this.confirmParams);
        }
    },
    cancel() {
        this.show = false;
        if (this.cancelMethod) {
            Livewire.emit(this.cancelMethod, this.cancelParams);
        }
    }
}"
    x-on:confirm.window="
        show=true;
        title=$event.detail.title ;
        message=$event.detail.message;
        confirmButtonText = $event.detail.confirmButtonText;
        cancelButtonText = $event.detail.cancelButtonText;
        confirmMethod = $event.detail.confirmMethod;
        cancelMethod = $event.detail.cancelMethod;
        confirmParams = $event.detail.confirmParams;
        cancelParams = $event.detail.cancelParams;
       ">
    <div x-cloak
        x-show="show"
        class="relative z-50"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true">
        <div x-cloak
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-cloak
                    x-show="show"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden rounded-lg border border-red-500 bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                    <div>
                        <div class="mx-auto flex items-center justify-center rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-12 w-12 text-red-600">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-lg font-medium leading-6 text-gray-900"
                                id="modal-title"
                                x-text="title"></h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500"
                                    x-text="message">

                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                        <button type="button"
                            x-on:click="confirm()"
                            class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:col-start-2 sm:text-sm"
                            x-text="confirmButtonText ?? 'Confirm'">
                        </button>
                        <button type="button"
                            x-on:click="cancel()"
                            class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:col-start-1 sm:mt-0 sm:text-sm"
                            x-text="cancelButtonText ?? 'Cancel'">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
