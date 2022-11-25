@props(['name'])
@error('{{ $name }}')
    <span class="ml-1 text-red-600 text-start">
        {{ $message }}
    </span>
@enderror
