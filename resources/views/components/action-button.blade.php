@props(['href'])
<a href="{{ $href }}" {{ $attributes->merge([
    'class' => 'text-center font-bold rounded-md p-2 text-white inline-block bg-gradient-to-r from-cyan-400 to-rose-500 shadow-md hover:shadow-lg dark:hover:drop-shadow-[0_0_10px_rgba(34,211,238,0.5)] transition-all duration-300'
]) }}>
    {{ $slot }}
</a>
