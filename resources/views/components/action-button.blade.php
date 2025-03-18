@props(['href'])
<a href="{{ $href }}" {{ $attributes->merge(['class' => 'text-center font-bold rounded-md p-2 bg-blue-500/70 inline-block text-white hover:bg-blue-600/70 transition-colors']) }}>
    {{ $slot }}
</a>
