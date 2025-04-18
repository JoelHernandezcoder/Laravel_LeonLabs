<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.Sales', [], session('lang','en')) }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
                <h1 class="dark:text-white font-bold text-xl mb-4">{{ __('messages.List', [], session('lang','en')) }}</h1>
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="border-b">
                        <th class="p-2 dark:text-white">ID</th>
                        <th class="p-2 dark:text-white">{{ __('messages.Client', [], session('lang','en')) }}</th>
                        <th class="p-2 dark:text-white">Total U$D</th>
{{--                        <th class="p-2 dark:text-white">Delivery Waiting Time</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($sales ?? [] as $sale)
                        <tr class="border-b">
                            <td class="p-2">
                                <a href="/sales/{{ $sale->id }}" class="text-blue-800">{{ $sale->id }}</a>
                            </td>
                            <td class="p-2 dark:text-white">{{ $sale->client->name }}</td>
                            <td class="p-2 dark:text-white">{{ $sale->total }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <x-forms.divider/>
                <div class="mx-4">
                   {{$sales->links()}}
                </div>
                <div class="text-center mt-4">
                    <x-action-button href="/sales/create">{{ __('messages.Register Sale', [], session('lang','en')) }}</x-action-button>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

