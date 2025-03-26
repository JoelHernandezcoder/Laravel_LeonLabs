<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Lines
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
                <h1 class="dark:text-white font-bold text-xl mb-4">List</h1>
                    @foreach ($lines ?? [] as $line)
                    <div class="dark:bg-gray-700 text-center bg-gray-100 mx-5 p-4 rounded-md mb-4">
                        <li class="dark:text-white font-bold text-xl mx-8 mt-4 text-blue-800">
                            <a href="/sales/{{ $line->id}}">{{$line->name}}</a>
                        </li>
                    </div>
                    @endforeach
                <x-forms.divider/>
                <div class="text-center mb-8">
                    <x-action-button href="/production" >Production Orders</x-action-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
