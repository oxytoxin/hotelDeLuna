{{-- <div class="table w-full ">
    <div class="table-header-group ">
        <div class="table-row">
            <div class="table-cell text-left ">Song</div>
            <div class="table-cell text-left ">Artist</div>
            <div class="table-cell text-left ">Year</div>
        </div>
    </div>
    <div class="table-row-group bg-white rounded-lg">
        @for ($i = 0; $i < 5; $i++)
            <div class="table-row border">
                <div
                    class="table-cell border-t-8 shadow-b-md border-gray-100 whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                    The
                    Sliding Mr. Bones (Next Stop, Pottersville)
                </div>
                <div
                    class="table-cell border-t-8 border-gray-100 whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                    Malcolm Lockyer
                </div>
                <div
                    class="table-cell border-t-8 border-gray-100  whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                    1961
                </div>
            </div>
        @endfor
    </div>
</div> --}}
<div>
    <div>
        <div>
            <div>
                <div>
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name
                                </th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Title</th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @for ($i = 0; $i < 10; $i++)
                                <tr class="rounded-xl">
                                    <td
                                        class="whitespace-nowrap border-t-4 border-gray-100 my-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        Lindsay Walton</td>
                                    <td
                                        class="whitespace-nowrap border-t-4 border-gray-100 px-3 py-4 text-sm text-gray-500">
                                        Front-end Developer
                                    </td>
                                    <td
                                        class="whitespace-nowrap border-t-4 border-gray-100 px-3 py-4 text-sm text-gray-500">
                                        lindsay.walton@example.com
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
