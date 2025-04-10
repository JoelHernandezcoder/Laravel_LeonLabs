<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $client->name }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="space-y-8 mt-4">
                    <div class="flex">
                        <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                            {{ __('messages.Country', [], session('lang','en')) }}: {{ $client->country }}
                        </p>
                        @php
                            $countryCodes = config('country_codes');
                            $countryCode = $countryCodes[$client->country] ?? null;
                        @endphp

                        @if ($countryCode)
                            <img
                                src="https://flagcdn.com/60x45/{{ $countryCode }}.png"
                                alt="{{ $client->country }}"
                            >
                        @else
                            <p class="dark:text-white">
                                {{ __('messages.No country flag available', [], session('lang','en')) }}
                            </p>
                        @endif
                    </div>

                    <p class="dark:text-white text-lg mx-8 text-blue-800">
                        {{ __('messages.Address', [], session('lang','en')) }}: {{ $client->address }}
                    </p>
                    <p class="dark:text-white text-lg mx-8 text-blue-800">
                        {{ __('messages.Phone', [], session('lang','en')) }}: {{ $client->phone }}
                    </p>
                    <p class="dark:text-white text-lg mx-8 text-blue-800">
                        {{ __('messages.Email', [], session('lang','en')) }}: {{ $client->email }}
                    </p>

                    <h1 class="dark:text-white mx-8 mt-4 font-bold text-xl">
                        {{ __('messages.Sales', [], session('lang','en')) }}
                    </h1>

                    <ul class="mx-5 mt-4 space-y-4">
                        @forelse ($sales as $sale)
                            <li class="dark:bg-gray-700 bg-gray-100 p-4 rounded-md">
                                <a class="dark:text-white text-lg text-blue-800" href="/sales/{{ $sale->id }}">
                                    <strong>• {{ __('messages.ID', [], session('lang','en')) }}:</strong> {{ $sale->id }}
                                    | <strong>{{ __('messages.Client', [], session('lang','en')) }}:</strong> {{ $sale->client->name }}
                                    | <strong>{{ __('messages.Total', [], session('lang','en')) }}:</strong> {{ $sale->total }} U$D
                                </a>
                            </li>
                        @empty
                            <li class="dark:text-white mx-8 mt-4">
                                {{ __('messages.No sales found', [], session('lang','en')) }}
                            </li>
                        @endforelse
                    </ul>


                    <div class="ml-4">
                        <x-action-button href="/clients">
                            {{ __("messages.Client's List", [], session('lang','en')) }}
                        </x-action-button>
                    </div>

                    <x-forms.divider/>

                    <form method="POST" action="{{ $client->id }}">
                        @csrf
                        @method('DELETE')
                        <div class="text-end mx-4 mb-4">
                            <x-danger-button>
                                {{ __('messages.Delete Client', [], session('lang','en')) }}
                            </x-danger-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
