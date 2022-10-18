@props([
    'headers' => [],
    'paginations' => null,
    'topLeft' => null,
    'topRight' => null,
])
<div>
    <div>
        <div class="flex flex-col">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden border border-gray-300 shadow-sm md:rounded-lg">
                        <div class="flex justify-start px-2 py-1.5 bg-white border-b border-gray-200 ">
                            <div class="flex space-x-2">
                                {{ $topLeft }}
                            </div>
                            <div>
                                {{ $topRight }}
                            </div>
                        </div>
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-primary-600">
                                <tr>
                                    @foreach ($headers as $header)
                                        <th scope="col"
                                            class="py-2 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-white uppercase sm:pl-6">
                                            {{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                {{ $slot }}
                            </tbody>
                        </table>
                    </div>
                    <div class="py-2">
                        {{ $pagination ?? '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
