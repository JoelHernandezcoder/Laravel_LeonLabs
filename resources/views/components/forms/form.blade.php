@php
    $formMethod = strtoupper($attributes->get('method', 'GET'));
    $htmlMethod = in_array($formMethod, ['GET', 'POST']) ? $formMethod : 'POST';
@endphp

<form method="{{ $htmlMethod }}" action="{{ $attributes->get('action') }}" {!! $attributes->except(['method', 'action'])->merge(['class' => 'max-w-2xl mx-auto space-y-6']) !!}>
    @if ($htmlMethod !== 'GET')
        @csrf
    @endif

    {{-- Si se usó un método distinto de GET o POST (por ejemplo, PUT, DELETE, PATCH) incluimos también el campo oculto _method --}}
    @if (!in_array($formMethod, ['GET', 'POST']))
        @method($formMethod)
    @endif

    {{ $slot }}
</form>
