@props(['class' => ''])

<button type="submit" {{ $attributes->merge(['class' => "bg-green-800/70 hover:bg-green-900/70 text-white rounded-md py-2 px-6 font-bold $class"]) }}>
    {{ $slot }}
</button>
