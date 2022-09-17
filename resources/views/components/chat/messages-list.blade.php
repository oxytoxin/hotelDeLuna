<div>
    <div class="flow-root">
        <ul role="list"
            class="divide-y divide-gray-200 ">
            @for ($i = 0; $i < 20; $i++)
                <li class="px-3 py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="w-8 h-8 rounded-full"
                                src="https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                alt="">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">Leonard
                                Krasner
                            </p>
                            <p class="text-sm text-gray-500 truncate">@leonardkrasner</p>
                        </div>
                        <div>
                            <a href="#"
                                class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">View</a>
                        </div>
                    </div>
                </li>
            @endfor
        </ul>
    </div>
</div>
