<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $supply->name }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <p class="flex justify-end sm:items-center text-lg mx-8 mt-4">
                    <span class="rounded-md bg-red-600 text-white px-2 py-1">Expiration Date: {{$supply->expiration_date}}</span>
                </p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Entry Date: {{$supply->entry_date}}</p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Stock: {{$supply->stock}} {{$supply->unit_code}}</p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Price: ${{$supply->price}}</p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Supplier: {{$supply->supplier}}</p>

                <x-forms.divider/>

                <h1 class="dark:text-white mx-8 mt-4 font-bold text-xl">Used in the Production of Medication:</h1>

                <ul>
                    <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">{{ $medication}}</p>
                </ul>

                <x-forms.divider/>

                <div class="ml-4">
                    <x-action-button href="/supplies">Supplies's List</x-action-button>
                </div>

                <x-forms.divider/>

                <form method="POST" action="{{$supply->id}}">
                    @csrf
                    @method('DELETE')
                    <div class="text-end mx-4 mb-4">
                        <x-danger-button>Delete Supply</x-danger-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
