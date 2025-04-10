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
                @php
                $emoji = match($order->state) {
                    0 => '⏳',
                    1 => '⚙️',
                    default => '✅',
                };
                $state = match($order->state) {
                    0 => __('messages.Paused', [], session('lang','en')),
                    1 => __('messages.In Progress', [], session('lang','en')),
                    default => __('messages.Completed', [], session('lang','en')),
                };
                @endphp
                <div class="flex flex-row justify-end mt-4 mr-4">
                    <p class="text-2xl">{{$emoji}}</p>
                    <p class="text-2xl">{{$state}}</p>
                </div>

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

                <ul class="p-8">
                    @if($line)
                        <x-action-button href="/lines/ {{ $line->id }}">
                            {{ $line->name }}
                        </x-action-button>
                    @else
                        <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">{{ __('messages.No production line assigned', [], session('lang', 'en')) }}</p>
                    @endif
                </ul>



                <x-forms.divider/>

                <div class="text-start ml-4 mb-4">
                    <x-action-button href="/production">
                        {{ __("messages.Production Order's List", [], session('lang','en')) }}
                    </x-action-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
