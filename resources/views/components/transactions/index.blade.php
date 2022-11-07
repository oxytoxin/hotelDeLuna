@props([
    'headers' => [],
    'body',
])
<div wire:key="transactions">
    <div class="flex flex-col">
        <div>
            <div class="inline-block min-w-full py-2 align-middle">
                <div class="shadow-sm ring-1 ring-black ring-opacity-5">
                    <table class="min-w-full border-separate"
                        style="border-spacing: 0">
                        <thead class="bg-primary-700">
                            <tr>
                                @foreach ($headers as $header)
                                    <th scope="col"
                                        class="sticky top-0 z-10 border-b border-gray-300 bg-opacity-75 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">
                                        {{ $header }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            {{ $body }}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
