<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Production Order: {{ $prod_order->id }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Batch: {{$prod_order->batch}}</p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Start Date: {{$prod_order->start_date}}</p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">End Date: {{$prod_order->end_date}}</p>
                <h1 class="dark:text-white mx-8 mt-4 font-bold text-xl">Production Line</h1>
                <ul>
                    <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800"></p>
                </ul>

                <x-forms.divider/>

                 @if( $prod_order->state == 0)
                    <x-forms.form method="POST" action="/production/{{ $prod_order->id }}/run">
                        @csrf
                        <div class="text-center py-4">
                            <x-forms.button>Run</x-forms.button>
                        </div>
                    </x-forms.form>
                @endif

                <x-forms.divider/>

                <div class="ml-4 mb-4">
                    <x-action-button href="/production">Production Order's List</x-action-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
