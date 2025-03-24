<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Sale N° {{$sale->id}}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Client: {{$sale->client->name}}</p>
                <div class="flex">
                    <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Country: {{ $sale->client->country }}</p>
                    @php
                        $countryCodes = config('country_codes');
                        $countryCode = $countryCodes[$sale->client->country] ?? null;
                    @endphp

                    @if ($countryCode)
                        <img src="https://flagcdn.com/60x45/{{ $countryCode }}.png"
                             alt="{{ $sale->client->country }}">
                    @else
                        <p>No country flag available</p>
                    @endif
                </div>

                <x-forms.divider/>

                @foreach($sale->medications as $medication)
                    <div class="dark:bg-gray-700 bg-gray-100 mx-5 p-4 rounded-md mb-4">
                        <ul>
                            <div class="flex justify-between">
                                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 mt-10 ml-8">
                                    Medicación: {{ $medication->name }}
                                </h2>
                                <img class="p-2 rounded-sm" src="{{$medication->photo}}" alt="" width="100" height="60" class="ml-3">
                            </div>
                            <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Precio: {{ $medication->price }}</p>
                            <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Unidades: {{ $medication->pivot->units }}</p>
                            <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Subtotal: {{ $medication->pivot->sub_total }}</p>
                            @foreach($medication->orders as $order)
                                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Lote: {{ $order->batch }}</p>
                            @endforeach
                        </ul>
                    </div>
                @endforeach

                <x-forms.divider/>

                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Agreed Date: {{$sale->agreed_date}}</p>
                <x-forms.divider/>

                <div class="ml-4">
                    <x-action-button href="/sales">Sale's List</x-action-button>
                </div>

                <x-forms.divider/>

                <form method="POST" action="{{$sale->id}}">
                    @csrf
                    @method('DELETE')
                    <div class="text-end mx-4 mb-4">
                        <x-danger-button>Delete Sale</x-danger-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
