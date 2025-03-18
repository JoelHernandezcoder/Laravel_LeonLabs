<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $client->name }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="space-y-20 mt-4">
                    <div class="flex">
                        <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Country: {{ $client->country }}</p>
                        @php
                            $countryCodes = config('country_codes');
                            $countryCode = $countryCodes[$client->country] ?? null;
                        @endphp

                        @if ($countryCode)
                            <img src="https://flagcdn.com/60x45/{{ $countryCode }}.png"
                                 alt="{{ $client->country }}">
                        @else
                            <p>No country flag available</p>
                        @endif
                    </div>


                    <h1 class="dark:text-white mx-8 mt-4 font-bold text-xl">Sales</h1>
                    <ul>
                        @foreach ($sales as $sale)
                            <a class="dark:text-white text-lg mx-8 mt-4 text-blue-800">{{ $sale->details }}</a>
                        @endforeach
                    </ul>

                    <x-forms.divider/>

                    <div class="ml-4">
                        <x-action-button href="/clients">Client's List</x-action-button>
                    </div>

                    <x-forms.divider/>

                    <form method="POST" action="{{$client->id}}">
                        @csrf
                        @method('DELETE')
                        <div class="text-end mx-4 mb-4">
                            <x-danger-button>Delete Client</x-danger-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
