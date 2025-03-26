<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $medication->name }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <img class="p-2 rounded-sm" src="{{$medication->photo}}" alt="" width="100" height="60" class="ml-3">
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Price: ${{$medication->price}}</p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">{{$medication->description}}</p>

                <x-forms.divider/>
                <h1 class="dark:text-white mx-8 mt-4 font-bold text-xl">Production Supply List (Per Dose)</h1>
                <ul>
                    @foreach($supplies as $supply)
                        <div class="dark:bg-gray-700 bg-gray-100 mx-5 p-4 rounded-md mb-4">
                            <li class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                                <a href="/supplies/{{ $supply->id}}"><strong>• Supply:</strong> {{ $supply->name }} | <strong>Quantity per unit: </strong> {{ $supply->pivot->quantity_per_unit }} {{$supply->unit_code}}</a>
                            </li>
                        </div>
                    @endforeach
                </ul>

                <x-forms.divider/>

                <h1 class="dark:text-white mx-8 mt-4 font-bold text-xl">{{$medication->name}}'s Sales</h1>
                <ul>
                    @foreach($medication->sales ?? [] as $sale)
                        <div class="dark:bg-gray-700 bg-gray-100 mx-5 p-4 rounded-md mb-4">
                            <li class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                                <a href="/sales/{{ $sale->id}}"><strong>• Id:</strong> {{ $sale->id}} | Client:</strong> {{ $sale->client->name }} |<strong> Quantity:</strong>  {{ $sale->pivot->quantity }} units | <strong> Total:</strong>  {{ $sale->total }} U$D</strong></a>
                            </li>
                        </div>
                    @endforeach
                </ul>

                <x-forms.divider/>

                <div class="ml-4">
                    <x-action-button href="/medications">Medication's List</x-action-button>
                </div>

                <x-forms.divider/>

                <form method="POST" action="{{$medication->id}}">
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
