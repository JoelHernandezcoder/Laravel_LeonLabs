<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{-- Mostramos el nombre tal cual viene de la DB --}}
            {{ $medication->name }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <img
                    class="p-2 rounded-sm ml-3"
                    src="{{ $medication->photo }}"
                    alt="{{ $medication->name }}"
                    width="100"
                    height="60"
                />

                {{-- Precio --}}
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                    {{ __('messages.Price', [], session('lang','en')) }}: ${{ $medication->price }}
                </p>

                {{-- Descripción --}}
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                    {{ $medication->description }}
                </p>

                <x-forms.divider/>

                {{-- Lista de Suministros para Producción (por dosis) --}}
                <h1 class="dark:text-white mx-8 mt-4 font-bold text-xl">
                    {{ __('messages.Production Supply List (Per Dose)', [], session('lang','en')) }}
                </h1>
                <ul>
                    @foreach($supplies as $supply)
                        <div class="dark:bg-gray-700 bg-gray-100 mx-5 p-4 rounded-md mb-4">
                            <li class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                                <a href="/supplies/{{ $supply->id }}">
                                    <strong>• {{ __('messages.Supply', [], session('lang','en')) }}:</strong>
                                    {{ $supply->name }}
                                    |
                                    <strong>{{ __('messages.Quantity per unit', [], session('lang','en')) }}:</strong>
                                    {{ $supply->pivot->quantity_per_unit }}
                                    {{ $supply->unit_code }}
                                </a>
                            </li>
                        </div>
                    @endforeach
                </ul>

                <x-forms.divider/>

                {{-- Ventas de este medicamento --}}
                <h1 class="dark:text-white mx-8 mt-4 font-bold text-xl">
                    {{ $medication->name }}'s {{ __('messages.Sales', [], session('lang','en')) }}
                </h1>
                <ul>
                    @foreach($medication->sales ?? [] as $sale)
                        <div class="dark:bg-gray-700 bg-gray-100 mx-5 p-4 rounded-md mb-4">
                            <li class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                                <a href="/sales/{{ $sale->id }}">
                                    <strong>• {{ __('messages.ID', [], session('lang','en')) }}:</strong> {{ $sale->id }}
                                    | <strong>{{ __('messages.Client', [], session('lang','en')) }}:</strong> {{ $sale->client->name }}
                                    | <strong>{{ __('messages.Quantity', [], session('lang','en')) }}:</strong>  {{ $sale->pivot->quantity }} {{ __('messages.units', [], session('lang','en')) }}
                                    | <strong>{{ __('messages.Total', [], session('lang','en')) }}:</strong>  {{ $sale->total }} U$D
                                </a>
                            </li>
                        </div>
                    @endforeach
                </ul>

                <x-forms.divider/>

                {{-- Volver a la lista de medicamentos --}}
                <div class="ml-4">
                    <x-action-button href="/medications">
                        {{ __("messages.Medication's List", [], session('lang','en')) }}
                    </x-action-button>
                </div>

                <x-forms.divider/>

                {{-- Botón para eliminar el medicamento --}}
                <form method="POST" action="{{ $medication->id }}">
                    @csrf
                    @method('DELETE')
                    <div class="text-end mx-4 mb-4">
                        <x-danger-button>
                            {{ __('messages.Delete Medication', [], session('lang','en')) }}
                        </x-danger-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
