<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Sale N° {{$sale->id}}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Client: {{$sale->client->name}} </p>
                <div class="flex">
                    <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Country: {{ $sale->client->country }}</p>
                    @php
                        $countryCodes = config('country_codes');
                        $countryCode = $countryCodes[$sale->client->country] ?? null;
                    @endphp

                    @if ($countryCode)
                        <img  src="https://flagcdn.com/60x45/{{ $countryCode }}.png"
                             alt="{{ $sale->client->country }}">
                    @else
                        <p>No country flag available</p>
                    @endif
                </div>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Medication: {{$sale->medication->name}}</p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Batch: {{$sale->production_order->batch}}</p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Quantity: {{$sale->quantity}}</p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Subtotal: U$D {{$sale->sub_total}}</p>



                <x-forms.divider/>

                <div class="ml-4">
                    <x-action-button href="/medications">Medication's List</x-action-button>
                </div>

                <x-forms.divider/>

                <form method="POST" action="{{$sale->id}}">
                    @csrf
                    @method('DELETE')
                    <div class="text-end mx-4 mb-4">
                        <x-danger-button>Delete Medication</x-danger-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
