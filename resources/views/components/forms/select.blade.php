@props(['label', 'name', 'options' => []])

@php
    $defaults = [
        'id' => $name,
        'name' => $name,
        'class' => 'rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full'
    ];
@endphp

<x-forms.field :$label :$name>
    <select {{ $attributes->merge($defaults) }}>
        @foreach ($options as $value => $text)
            <option class="bg-gray-100" value="{{ $value }}">{{ $text }}</option>
        @endforeach
    </select>
</x-forms.field>
