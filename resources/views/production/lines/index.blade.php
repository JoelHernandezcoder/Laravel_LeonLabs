<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.Lines', [], session('lang','en')) }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
                <h1 class="dark:text-white font-bold text-xl mb-4">
                    {{ __('messages.List', [], session('lang','en')) }}
                </h1>

                @foreach ($lines ?? [] as $line)
                    <div class="dark:bg-gray-800 text-center bg-gray-100 mx-5 p-4 rounded-md">
                        <x-action-button class="w-48" href="/lines/{{ $line->id }}">
                            {{ $line->name }}
                        </x-action-button>
                    </div>
                @endforeach

                <div class="mt-4">
                    <x-action-button href="/production">
                        {{ __('messages.Production Orders', [], session('lang','en')) }}
                    </x-action-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
