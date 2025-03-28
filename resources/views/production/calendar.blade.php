@php use Carbon\Carbon; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Production Calendar
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">

                <!-- Navegación de meses -->
                <div class="flex justify-between items-center mb-4">
                    <x-action-button
                        href="{{ route('production', [
                            'month' => $currentMonth - 1 < 1 ? 12 : $currentMonth - 1,
                            'year' => $currentMonth - 1 < 1 ? $currentYear - 1 : $currentYear
                        ]) }}"
                        class="text-blue-500 hover:text-blue-700">
                        &lt; Previous
                    </x-action-button>

                    <span class="font-bold text-lg">
                        {{ Carbon::create($currentYear, $currentMonth)->monthName }} {{ $currentYear }}
                    </span>

                    <x-action-button
                        href="{{ route('production', [
                            'month' => $currentMonth + 1 > 12 ? 1 : $currentMonth + 1,
                            'year' => $currentMonth + 1 > 12 ? $currentYear + 1 : $currentYear
                        ]) }}"
                        class="text-blue-500 hover:text-blue-700">
                        Next &gt;
                    </x-action-button>
                </div>

                <!-- Calendario -->
                <div class="bg-blue-100/50 rounded-md p-4">
                    <div class="grid grid-cols-7 gap-2 text-center">
                        <div class="font-semibold">Mon</div>
                        <div class="font-semibold">Tue</div>
                        <div class="font-semibold">Wed</div>
                        <div class="font-semibold">Thu</div>
                        <div class="font-semibold">Fri</div>
                        <div class="font-semibold text-red-500">Sat</div>
                        <div class="font-semibold text-red-500">Sun</div>

                        @php
                            $firstDay = Carbon::create($currentYear, $currentMonth, 1);
                            // Ajuste: Si el día de la semana es domingo (0) se usa 6 para que inicie en lunes.
                            $emptyDays = $firstDay->dayOfWeek == 0 ? 6 : $firstDay->dayOfWeek - 1;
                            $monthStart = $firstDay->copy()->startOfMonth();
                            $monthEnd = $firstDay->copy()->endOfMonth();

                            $ordersThisMonth = $prodOrders->filter(function($order) use ($monthStart, $monthEnd) {
                                $start = Carbon::parse($order->start_date);
                                $end = $order->end_date ? Carbon::parse($order->end_date) : now();
                                return $start <= $monthEnd && $end >= $monthStart;
                            });

                            // Definimos 10 colores pasteles
                            $colors = [
                                1 => 'background-color: #bbf7d0', // Verde pastel
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
                        @endphp

                        @for ($i = 0; $i < $emptyDays; $i++)
                            <div></div>
                        @endfor

                        @foreach (range(1, $firstDay->daysInMonth) as $day)
                            @php
                                $currentDay = Carbon::create($currentYear, $currentMonth, $day);
                                $hasProduction = false;
                                $dayOrders = [];

                                foreach ($ordersThisMonth as $order) {
                                    if ($order->start_date && $currentDay->between($order->start_date, $order->end_date ?? $currentDay)) {
                                        $dayOrders[] = $order;
                                        $hasProduction = true;
                                    }
                                }
                            @endphp

                            <div class="p-4 border border-gray-300 rounded-lg hover:bg-gray-200"
                                 style="{{ $hasProduction ? 'background-color: #bfdbfe' : '' }}; {{ $currentDay->isWeekend() ? 'color: #ef4444' : '' }}">
                                <span class="font-bold">{{ $day }}</span>

                                @foreach ($dayOrders as $order)
                                    @php
                                        // Usamos ($order->id - 1) para que el primer pedido (id=1) obtenga color 1 (verde)
                                        $color = $colors[(($order->id - 1) % 10) + 1];
                                    @endphp

                                    <div class="p-2 mt-2 rounded-lg shadow-sm text-xs" style="{{ $color }}">
                                        Order: {{ $order->id }}<br>
                                        Batch: {{ $order->batch }}
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>

                <x-forms.divider/>

                <!-- Lista de órdenes de producción -->
                <h1 class="dark:text-white text-center font-bold text-xl mb-4">
                    Production Orders ({{ Carbon::create($currentYear, $currentMonth)->monthName }})
                </h1>
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="border-b">
                        <th class="p-2 dark:text-white">ID</th>
                        <th class="p-2 dark:text-white">Batch</th>
                        <th class="p-2 dark:text-white">State</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($ordersThisMonth as $order)
                        @php
                            $color = $colors[(($order->id - 1) % 10) + 1];
                        @endphp
                        <tr class="border-b" style="{{ $color }}">
                            <td class="p-2">
                                <a href="/production/{{ $order->id }}" class="text-blue-800 hover:text-blue-600">
                                    {{ $order->id }}
                                </a>
                            </td>
                            <td class="p-2 dark:text-white">{{ $order->batch }}</td>
                            <td class="p-2 dark:text-white">
                                {{ match($order->state) {
                                    0 => 'Not Started',
                                    1 => 'In Progress',
                                    default => 'Completed'
                                } }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <x-forms.divider/>

                <div class="text-center mb-8">
                    <x-action-button href="/lines">Production Lines</x-action-button>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
