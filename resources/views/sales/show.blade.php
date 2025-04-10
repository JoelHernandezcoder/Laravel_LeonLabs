<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.Sale', [], session('lang','en')) }} N° {{$sale->id}}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex">
                    <p class="dark:text-white text-lg ml-8 mt-4 text-blue-800">{{ __('messages.Client', [], session('lang','en')) }} </p>
                    <a href="/clients/{{$sale->client->id}}">
                        <p class="dark:text-blue-400 text-lg mt-4 mx-2 text-blue-800">{{$sale->client->name}}</p>
                    </a>
                </div>
                <div class="flex">
                    <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">{{ __('messages.Country', [], session('lang','en')) }}: {{ $sale->client->country }}</p>
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
                                    {{ __('messages.Medication', [], session('lang','en')) }}: {{ $medication->name }}
                                </h2>
                                <img class="p-2 rounded-sm" src="{{$medication->photo}}" alt="" width="100" height="60" class="ml-3">
                            </div>
                            <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">{{ __('messages.Price U$D', [], session('lang','en')) }}: {{ $medication->price }}</p>
                            <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">{{ __('messages.Quantity', [], session('lang','en')) }}: {{ $medication->pivot->quantity }} {{ __('messages.units', [], session('lang','en')) }}</p>
                            <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Subtotal: U$D {{ $medication->pivot->sub_total }}</p>

                            @if($medication->orders->count() > 1)
                                <p class="dark:text-white text-lg mx-8 mt-4 font-bold text-blue-800">{{ __('messages.Batch', [], session('lang','en')) }} {{ __('messages.Medication', [], session('lang','en')) }}</p>
                                <div class="ml-8 mt-2 space-y-2">
                                    @foreach($medication->orders as $order)
                                        <p class="dark:text-white text-lg text-blue-800">
                                            • {{ $order->batch }}
                                            @if(isset($order->pivot->quantity))
                                                | {{ $order->pivot->quantity }} units
                                            @endif
                                        </p>
                                    @endforeach
                                </div>
                            @else
                                <p class="dark:text-white text-lg mx-8 mt-4 font-bold text-blue-800">{{ __('messages.Batch', [], session('lang','en')) }} {{ __('messages.Medication', [], session('lang','en')) }}</p>
                                <div class="ml-8 mt-2 space-y-2">
                                    @foreach($medication->orders as $order)
                                        <p class="dark:text-white text-lg text-blue-800">
                                            • {{ $order->batch }}
                                        </p>
                                    @endforeach
                                </div>
                            @endif
                        </ul>
                    </div>
                @endforeach

                <x-forms.divider/>
                <h2 class="font-semibold text-center text-xl text-gray-800 dark:text-gray-200 mt-10 ml-8">
                    Total: U$D {{$sale->total}}
                </h2>
                <x-forms.divider/>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">{{ __('messages.Agreed Date', [], session('lang','en')) }}: {{$sale->agreed_date}}</p>
                <x-forms.divider/>
                <div class="ml-4">
                    <x-action-button href="/sales">{{ __('messages.Sales list', [], session('lang','en')) }} </x-action-button>
                </div>

                <x-forms.divider/>

                <form method="POST" action="{{$sale->id}}">
                    @csrf
                    @method('DELETE')
                    <div class="text-end mx-4 mb-4">
                        <x-danger-button> {{ __('messages.Delete', [], session('lang','en')) }} {{ __('messages.Sale', [], session('lang','en')) }}</x-danger-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
