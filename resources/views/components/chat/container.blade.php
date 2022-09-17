<div x-data="{ expand: false, showConversation: false }">
    <div class="fixed bottom-0 border shadow-xl right-10 ">
        <div class="h-full">
            <div class="flex items-center justify-between p-3 text-white border-b rounded-t-lg w-96 bg-primary-700">
                <h1> Chat</h1>
                <div class="flex items-center space-x-2">
                    <button x-on:click="expand = !expand">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            x-bind:class="{ 'rotate-180': expand }"
                            class="w-5 h-5 duration-300 ease-in-out delay-300">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4.5 12.75l7.5-7.5 7.5 7.5m-15 6l7.5-7.5 7.5 7.5" />
                        </svg>
                    </button>
                </div>
            </div>
            <div x-cloak
                x-show="expand"
                x-collapse>
                <div class="h-[23rem] w-96 backdrop-blur-sm shadow-md">
                    <div class="h-full overflow-y-auto">
                        <template x-if="showConversation==false">
                            <div>
                                <x-chat.messages-list />
                            </div>
                        </template>
                        <template x-if="showConversation">
                            <div>
                                <x-chat.conversation />
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
