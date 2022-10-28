@props(['status'])
<div>
    <span @class([
        'inline-flex border items-center rounded-full  px-3 py-0.5 text-sm font-medium',
        'bg-green-600 text-white border-green-600' => $status == 1,
        'bg-green-100 text-green-800 border-green-400' => $status == 2,
        'bg-gray-600 text-white border-gray-600' => $status == 3,
        'bg-violet-600 text-white border-violet-600' => $status == 4,
        'bg-black text-white border-black' => $status == 5,
        'bg-yellow-100 text-yellow-800 border-yellow-400' => $status == 6,
        'bg-red-600 text-white border-red-600' => $status == 7,
        'bg-red-100 text-red-600 border-red-400 ' => $status == 8,
        'bg-blue-100 text-blue-800 border-blue-400' => $status == 9,
    ])>
        {{ $slot }}
    </span>
</div>
