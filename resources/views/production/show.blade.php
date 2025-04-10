@php
    use Carbon\Carbon;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.Production Order', [], session('lang','en')) }}: {{ $order->id }}
        </h2>
    </x-slot>

    @php
        $stateOptions = [
            0 => __('messages.Paused', [], session('lang','en')),
            1 => __('messages.In Progress', [], session('lang','en')),
            2 => __('messages.Completed', [], session('lang','en'))
        ];
        $emojiOptions = [
            0 => '⏳',
            1 => '⚙️',
            2 => '✅'
        ];
    @endphp

    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4">
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="flex justify-end items-center mb-4">
                    <span class="text-2xl dark:text-white mr-2">{{ $stateOptions[$order->state] ?? $order->state }}</span>
                    <span class="text-2xl">{{ $emojiOptions[$order->state] ?? '' }}</span>
                </div>

                <div class="mb-6">
                    <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                        {{ __('messages.Batch', [], session('lang','en')) }}: {{ $order->batch }}
                    </p>
                    <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                        {{ __('messages.Start Date', [], session('lang','en')) }}: {{ $order->start_date }}
                    </p>
                    <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                        {{ __('messages.End Date', [], session('lang','en')) }}: {{ $order->end_date }}
                    </p>
                    <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                        {{ __('messages.Production Line', [], session('lang','en')) }}:
                        @if($line)
                            {{ $line->name }}
                        @else
                            {{ __('messages.No production line assigned', [], session('lang','en')) }}
                        @endif
                    </p>
                </div>

                <x-forms.divider />

                <x-forms.form
                    method="PUT"
                    action="{{ url('/production/order/' . $order->id) }}"
                    onsubmit="return confirm('{{ __('messages.Are you sure you want to modify the order?', [], session('lang','en')) }}');"
                >
                    <div class="space-y-6">
                        <x-forms.select
                            label="{{ __('messages.State', [], session('lang','en')) }}"
                            name="state"
                            :options="$stateOptions"
                            required
                            id="state"
                            :selected="$order->state"
                        />

                        <x-forms.input
                            label="{{ __('messages.Start Date', [], session('lang','en')) }}"
                            name="start_date"
                            type="date"
                            required
                            id="start_date"
                            value="{{ $order->start_date }}"
                        />

                        <x-forms.input
                            label="{{ __('messages.End Date', [], session('lang','en')) }}"
                            name="end_date"
                            type="date"
                            required
                            id="end_date"
                            value="{{ $order->end_date }}"
                        />

                        <x-forms.select
                            label="{{ __('messages.Production Line', [], session('lang','en')) }}"
                            name="production_line_id"
                            :options="$productionLines"
                            required
                            id="production_line_id"
                            :selected="$order->production_line_id"
                        />

                        <div class="text-center">
                            <x-forms.button
                                type="submit"
                                class="bg-yellow-400 hover:bg-yellow-500 mt-4"
                            >
                                {{ __('messages.Modify', [], session('lang','en')) }} {{ __('messages.Production Order', [], session('lang','en')) }}
                            </x-forms.button>
                        </div>
                    </div>
                </x-forms.form>

                <x-forms.divider/>

                <div class="mt-6">
                    <x-action-button href="/production">
                        {{ __('messages.Production Order\'s List', [], session('lang','en')) }}
                    </x-action-button>
                </div>
            </div>
        </div>
    </div>
{{--    line and state selected--}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let stateSelect = document.getElementById('state');
            if (stateSelect) {
                stateSelect.value = "{{ $order->state }}";
            }

            let lineSelect = document.getElementById('production_line_id');
            if (lineSelect) {
                lineSelect.value = "{{ $order->production_line_id }}";
            }
        });
    </script>
</x-app-layout>
