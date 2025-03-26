<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Supplies
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
                <h1 class="dark:text-white mx-8 my-8 font-bold text-xl">List</h1>
                <table class="mx-8 w-full text-left border-collapse">
                    <thead>
                    <tr class="border-b">
                        <th class="p-2 dark:text-white">ID</th>
                        <th class="p-2 dark:text-white">Name</th>
                        <th class="p-2 dark:text-white">Stock</th>
                        <th class="p-2 dark:text-white">Expiration Date</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($supplies ?? [] as $supply)
                            <tr class="border-b">
                                <td class="p-2">
                                    <a href="/supplies/{{$supply->id}}" class="text-blue-800">{{ $supply->id }}</a>
                                </td>
                                <td class="p-2 dark:text-white">{{ $supply->name }}</td>
                                <td class="p-2 dark:text-white">{{ $supply->stock }}</td>
                                <td class="p-2 dark:text-white">{{ $supply->expiration_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <x-forms.divider/>
                <div class="mx-4">
                    {{ $supplies->links() }}
                </div>
                <div class="text-center mb-8">
                    <x-action-button href="/supplies/create" >Create Supply</x-action-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

