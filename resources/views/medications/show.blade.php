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
                <h1 class="dark:text-white mx-8 mt-4 font-bold text-xl">Supplies</h1>
                <ul>
                    @foreach($supplies as $supply)
                        <li class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                            <strong>{{ $supply->name }}:</strong> {{ $supply->pivot->quantity_per_unit }} units
                        </li>
                    @endforeach
                </ul>

                <x-forms.divider/>

                <h1 class="dark:text-white mx-8 mt-4 font-bold text-xl">Sales</h1>
                <ul>
                    <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">{{ $medication->sale}}</p>
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
