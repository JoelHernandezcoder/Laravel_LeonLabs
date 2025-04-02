<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{-- "Production Order: {{ $order->id }}" --}}
            {{ __('messages.Production Order', [], session('lang','en')) }}: {{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                    {{ __('messages.Batch', [], session('lang','en')) }}: {{ $order->batch }}
                </p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                    {{ __('messages.Start Date', [], session('lang','en')) }}: {{ $order->start_date }}
                </p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                    {{ __('messages.End Date', [], session('lang','en')) }}: {{ $order->end_date }}
                </p>

                <x-forms.divider/>

                <h1 class="dark:text-white mx-8 mt-4 font-bold text-xl">
                    {{ __('messages.Production Line', [], session('lang','en')) }}
                </h1>
                <ul>
                    <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800"></p>
                </ul>

                <div class="ml-4 mt-4">
                    <x-forms.form
                        method="POST"
                        action="/production/order/{{ $order->id }}/line/{{ $order->line }}"
                        class="inline-block p-2"
                    >
                        @csrf
                        @method('PUT')
                        <select
                            id="line"
                            name="line"
                            onchange="this.form.submit()"
                            class="bg-white dark:bg-gray-600 dark:text-white border border-gray-300 dark:border-gray-700
                   rounded-md px-2 py-1 focus:outline-none"
                        >
                            @foreach ($lines ?? [] as $line)
                                <option value="{{ $line->id }}">
                                    Line {{ $line->id }}
                                </option>
                            @endforeach
                        </select>
                    </x-forms.form>
                </div>


                <x-forms.divider/>


                <form method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <div class="text-end mx-4 mb-4">
                        <x-forms.button>
                           Modify Production Order
                        </x-forms.button>
                    </div>
                </form>

                <x-forms.divider/>

                <div class="text-center mb-4">
                    <x-action-button href="/production">
                        {{ __("messages.Production Order's List", [], session('lang','en')) }}
                    </x-action-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
