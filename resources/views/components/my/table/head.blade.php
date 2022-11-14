@props(['name' => null])
<th scope="col"
    {{ $attributes->merge(['class' => 'py-3 pl-4 pr-3 text-left text-xs font-medium uppercase tracking-wide text-white sm:pl-6']) }}>
    {{ $name }}
    {{ $slot }}
</th>
