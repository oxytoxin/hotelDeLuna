@props(['status_id'])

@php
    function getClass()
    {
        switch ($status_id) {
            case 1:
                return 'bg-green-100 text-green-800 border-green-400';
            case 2:
                return 'bg-yellow-100 text-yellow-800 border-yellow-400';
            case 3:
                return 'bg-gray-100 text-gray-800 border-gray-400';
            case 4:
                return 'bg-rose-100 text-rose-800 border-rose-400';
            case 5:
                return 'bg-red-100 text-red-800 border-red-400';
            case 5:
                return 'bg-red-100 text-red-800 border-red-400';
        }
    }
@endphp
<span class="inline-flex border items-center rounded-full  px-3 py-0.5 text-sm font-medium ">Badge</span>
