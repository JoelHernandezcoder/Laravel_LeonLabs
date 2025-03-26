<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Production
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
                <h1 class="dark:text-white font-bold text-xl mb-4">List</h1>
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="border-b">
                        <th class="p-2 dark:text-white">ID</th>
                        <th class="p-2 dark:text-white">Batch</th>
                        <th class="p-2 dark:text-white">State</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($prod_orders ?? [] as $prod_order)
                        <tr class="border-b">
                            <td class="p-2">
                                <a href="/production/{{ $prod_order->id }}" class="text-blue-800">{{ $prod_order->id }}</a>
                            </td>
                            <td class="p-2 dark:text-white">{{ $prod_order->batch }}</td>
                            @if( !$prod_order->state)
                                <td class="p-2 dark:text-white">Not Started</td>
                            @elseif($prod_order->state == 1)
                                <td class="p-2 dark:text-white">In Progress</td>
                            @elseif($prod_order->state == 2)
                                <td class="p-2 dark:text-white">Completed</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <x-forms.divider/>
                <div class="mx-4">
                    {{ $prod_orders->links() }}
                </div>
                <div class="text-center mb-8">
                    <x-action-button href="/production/lines" >Production Lines</x-action-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
