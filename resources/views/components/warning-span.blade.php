@props(['href' => null])

@if ($href)
    <a href="{{ $href }}" class="bg-yellow-500 text-white text-sm px-2 py-1 rounded">
        {{ $slot }}
    </a>
@else
    <span class="bg-yellow-500 text-white text-sm px-2 py-1 rounded">
        {{ $slot }}
    </span>
@endif
