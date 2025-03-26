<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Production Calendar
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">

                <!-- Navegación de Meses -->
                <div class="flex justify-between items-center mb-4">
                    <a href="{{ route('production', ['month' => $currentMonth - 1 <= 0 ? 12 : $currentMonth - 1, 'year' => $currentMonth - 1 <= 0 ? $currentYear - 1 : $currentYear]) }}" class="text-blue-500 hover:text-blue-700">&lt; Previous</a>
                    <span class="font-bold text-lg">{{ \Carbon\Carbon::create($currentYear, $currentMonth)->monthName }} {{ $currentYear }}</span>
                    <a href="{{ route('production', ['month' => $currentMonth + 1 > 12 ? 1 : $currentMonth + 1, 'year' => $currentMonth + 1 > 12 ? $currentYear + 1 : $currentYear]) }}" class="text-blue-500 hover:text-blue-700">Next &gt;</a>
                </div>

                <!-- Calendario -->
                <div class="calendar mb-8">
                    <div class="calendar grid grid-cols-7 gap-2">
                        <div class="header text-center font-semibold">Mon</div>
                        <div class="header text-center font-semibold">Tue</div>
                        <div class="header text-center font-semibold">Wed</div>
                        <div class="header text-center font-semibold">Thu</div>
                        <div class="header text-center font-semibold">Fri</div>
                        <div class="header text-center font-semibold text-red-500">Sat</div>
                        <div class="header text-center font-semibold text-red-500">Sun</div>

                        <!-- Generar los días del mes -->
                        @foreach ($days as $day)
                            @php
                                // Comprobar si hay una orden de producción para este día
                                $orderForDay = $prodOrders->where('created_at', '>=', $day->startOfDay())
                                                         ->where('created_at', '<=', $day->endOfDay())
                                                         ->first();
                            @endphp
                            <div class="day text-center p-2 {{ $day->dayOfWeek == 6 || $day->dayOfWeek == 0 ? 'text-red-500' : '' }}
                                {{ $orderForDay ? 'bg-blue-200' : '' }}">
                                {{ $day->day }}
                                @if ($orderForDay)
                                    <div class="text-xs text-center mt-1">Order: {{ $orderForDay->batch }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tabla de Órdenes de Producción -->
                <h1 class="dark:text-white font-bold text-xl mb-4">Production Orders</h1>
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="border-b">
                        <th class="p-2 dark:text-white">ID</th>
                        <th class="p-2 dark:text-white">Batch</th>
                        <th class="p-2 dark:text-white">State</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($prodOrders ?? [] as $prodOrder)
                        <tr class="border-b">
                            <td class="p-2">
                                <a href="/production/{{ $prodOrder->id }}" class="text-blue-800">{{ $prodOrder->id }}</a>
                            </td>
                            <td class="p-2 dark:text-white">{{ $prodOrder->batch }}</td>
                            <td class="p-2 dark:text-white">{{ $prodOrder->state == 0 ? 'Not Started' : ($prodOrder->state == 1 ? 'In Progress' : 'Completed') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <x-forms.divider/>
                <div class="mx-4">
                    {{ $prodOrders->links() }}
                </div>
                <div class="text-center mb-8">
                    <x-action-button href="/lines" >Production Lines</x-action-button>
                </div>
            </div>
        </div>
    </div>

    <!-- Estilos personalizados para el calendario -->
    <style>
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
        }

        .calendar .header {
            font-weight: bold;
            background-color: #f0f0f0;
            padding: 8px;
        }

        .calendar .day {
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
        }

        .calendar .day:hover {
            background-color: #f0f0f0;
        }

        .calendar .weekend {
            color: red;
        }

        .calendar .bg-blue-200 {
            background-color: #cce4ff;
        }
    </style>
</x-app-layout>
