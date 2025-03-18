@props(['name', 'label'])

<div class="inline-flex items-center gap-x-2">
    <span class="dark:bg-white w-2 h-2 bg-black inline-block"></span>
    <label class="dark:text-white font-bold" for="{{ $name }}">{{ $label }}</label>
</div>
