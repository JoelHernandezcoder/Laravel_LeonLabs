@php use Carbon\Carbon; @endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.Production Calendar', [], session('lang','en')) }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">

                <div class="dark:bg-gray-800 bg-blue-100/50 rounded-md p-4">
                    {{-- Month navigation --}}
                    <div class="flex justify-between items-center mb-4">
                        <x-action-button
                            href="{{ route('production', [
                                'month' => $currentMonth - 1 < 1 ? 12 : $currentMonth - 1,
                                'year' => $currentMonth - 1 < 1 ? $currentYear - 1 : $currentYear
                            ]) }}"
                            class="text-blue-500 hover:text-blue-700"
                        >
                            {{ __('messages.Previous', [], session('lang','en')) }}
                        </x-action-button>

                        <span class="font-bold text-lg dark:text-white">
                            {{ Carbon::create($currentYear, $currentMonth)->monthName }} {{ $currentYear }}
                        </span>

                        <x-action-button
                            href="{{ route('production', [
                                'month' => $currentMonth + 1 > 12 ? 1 : $currentMonth + 1,
                                'year' => $currentMonth + 1 > 12 ? $currentYear + 1 : $currentYear
                            ]) }}"
                            class="text-blue-500 hover:text-blue-700"
                        >
                            {{ __('messages.Next', [], session('lang','en')) }}
                        </x-action-button>
                    </div>

                    <x-forms.divider/>
                    {{-- Calendar --}}
                    <div class="grid grid-cols-7 gap-2 text-center">
                        <div class="font-semibold dark:text-white">
                            {{ __('messages.Mon', [], session('lang','en')) }}
                        </div>
                        <div class="font-semibold dark:text-white">
                            {{ __('messages.Tue', [], session('lang','en')) }}
                        </div>
                        <div class="font-semibold dark:text-white">
                            {{ __('messages.Wed', [], session('lang','en')) }}
                        </div>
                        <div class="font-semibold dark:text-white">
                            {{ __('messages.Thu', [], session('lang','en')) }}
                        </div>
                        <div class="font-semibold dark:text-white">
                            {{ __('messages.Fri', [], session('lang','en')) }}
                        </div>
                        <div class="font-semibold text-red-500">
                            {{ __('messages.Sat', [], session('lang','en')) }}
                        </div>
                        <div class="font-semibold text-red-500">
                            {{ __('messages.Sun', [], session('lang','en')) }}
                        </div>

                        @php
                            $firstDay = Carbon::create($currentYear, $currentMonth, 1);
                            $emptyDays = $firstDay->dayOfWeek == 0 ? 6 : $firstDay->dayOfWeek - 1;
                            $monthStart = $firstDay->copy()->startOfMonth();
                            $monthEnd = $firstDay->copy()->endOfMonth();

                            $ordersThisMonth = $prodOrders->filter(function($order) use ($monthStart, $monthEnd) {
                                $start = Carbon::parse($order->start_date);
                                $end = $order->end_date ? Carbon::parse($order->end_date) : now();
                                return $start <= $monthEnd && $end >= $monthStart;
                            });

                            $colors = [
                                1 => 'background-color: #bbf7d0',
                                2 => 'background-color: #fef08a',
                                3 => 'background-color: #fed7aa',
                                4 => 'background-color: #fcb8b8',
                                5 => 'background-color: #bae6fd',
                                6 => 'background-color: #e0e7ff',
                                7 => 'background-color: #f9e0ff',
                                8 => 'background-color: #d1fae5',
                                9 => 'background-color: #ffedd5',
                                10 => 'background-color: #ffe4e6'
                            ];


                           // Language - Holidays: 'en' USA - 'es'Argentina.
                            $holidays = session('lang', 'en') === 'en'
                                ? config('holidays.usa')
                                : config('holidays.argentina');

                        @endphp

                        @for ($i = 0; $i < $emptyDays; $i++)
                            <div></div>
                        @endfor

                        @foreach (range(1, $firstDay->daysInMonth) as $day)
                            @php
                                $currentDay = Carbon::create($currentYear, $currentMonth, $day);
                                $dayOrders = [];
                                foreach ($ordersThisMonth as $order) {
                                    if ($order->start_date && $currentDay->between($order->start_date, $order->end_date ?? $currentDay)) {
                                        $dayOrders[] = $order;
                                    }
                                }
                               $isHoliday = in_array($currentDay->format('m-d'), $holidays);
                                $bgColor = $isHoliday ? 'background-color: #fecaca'
                                         : (count($dayOrders) ? 'background-color: #bfdbfe' : '');
                            @endphp

                            <div
                                class="p-4 border border-gray-300 rounded-lg hover:bg-gray-200"
                                style="{{ $bgColor }}; {{ $currentDay->isWeekend() ? 'color: #ef4444' : '' }}"
                            >
                                <span class="font-bold">{{ $day }}</span>

                                @foreach ($dayOrders as $order)
                                    @php
                                        $color = $colors[(($order->id - 1) % 10) + 1];
                                        $emoji = match($order->state) {
                                            0 => '⏳',
                                            1 => '⚙️',
                                            default => '✅',
                                        };
                                        $tooltip = match($order->state) {
                                            0 => __('messages.Paused', [], session('lang','en')),
                                            1 => __('messages.In Progress', [], session('lang','en')),
                                            default => __('messages.Completed', [], session('lang','en')),
                                        };
                                    @endphp

                                    <div class="p-2 mt-2 rounded-lg shadow-sm text-xs" style="{{ $color }}">
                                        {{-- Pantalla grande: detalles completos --}}
                                        <div class="hidden lg:block">
                                            <div class="flex justify-between">
                                                <p><strong>Order: {{ $order->id }}</strong></p>
                                                <p>
                                                    <span title="{{ $tooltip }}">{{ $emoji }}</span>
                                                </p>
                                            </div>
                                            <p class="text-gray-500">Batch: {{ $order->batch }}</p>
                                        </div>

                                        {{-- Pantalla chica: solo emoji + número --}}
                                        <div class="lg:hidden text-center font-semibold text-sm">
                                            <span title="{{ $tooltip }}">{{ $order->id }} {{ $emoji }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>

                <x-forms.divider/>

                <h1 class="dark:text-white text-center font-bold text-xl mb-4">
                    {{ __('messages.Production Orders List', [], session('lang','en')) }}
                    ({{ Carbon::create($currentYear, $currentMonth)->monthName }})
                </h1>

                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="border-b">
                        <th class="p-2 dark:text-white">{{ __('messages.ID', [], session('lang','en')) }}</th>
                        <th class="p-2 dark:text-white">{{ __('messages.Batch', [], session('lang','en')) }}</th>
                        <th class="p-2 dark:text-white">{{ __('messages.State', [], session('lang','en')) }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($ordersThisMonth as $order)
                        @php
                            $color = $colors[(($order->id - 1) % 10) + 1];
                        @endphp
                        <tr class="border-b" style="{{ $color }}">
                            <td class="p-2">
                                <a
                                    href="/production/order/{{ $order->id }}"
                                    class="text-blue-800 hover:text-blue-600"
                                >
                                    {{ $order->id }}
                                </a>
                            </td>
                            <td class="p-2">
                                {{ $order->batch }}
                            </td>
                            <td>
                                <div class="mb-6">
                                    <x-forms.form
                                        method="POST"
                                        action="/production/order/{{ $order->id }}"
                                        class="inline"
                                    >
                                        @csrf
                                        @method('PUT')
                                        <select
                                            name="state"
                                            onchange="this.form.submit()"
                                            class="bg-transparent border-none"
                                        >
                                            <option
                                                value="0"
                                                {{ $order->state == 0 ? 'selected' : '' }}
                                            >
                                                {{ __('messages.Paused', [], session('lang','en')) }}
                                            </option>
                                            <option
                                                value="1"
                                                {{ $order->state == 1 ? 'selected' : '' }}
                                            >
                                                {{ __('messages.In Progress', [], session('lang','en')) }}
                                            </option>
                                            <option
                                                value="2"
                                                {{ $order->state == 2 ? 'selected' : '' }}
                                            >
                                                {{ __('messages.Completed', [], session('lang','en')) }}
                                            </option>
                                        </select>
                                    </x-forms.form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <x-forms.divider/>

                <div class="text-center">
                    <x-action-button href="/lines">
                        {{ __('messages.Production Lines', [], session('lang','en')) }}
                    </x-action-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
