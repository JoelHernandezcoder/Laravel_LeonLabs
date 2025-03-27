@php use Carbon\Carbon; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Production
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">


                <div class="flex justify-between items-center mb-4">
                    <x-action-button href="{{ route('production', ['month' => $currentMonth - 1 <= 0 ? 12 : $currentMonth - 1, 'year' => $currentMonth - 1 <= 0 ? $currentYear - 1 : $currentYear]) }}" class="text-blue-500 hover:text-blue-700">&lt; Previous</x-action-button>
                    <span class="font-bold text-lg">{{ Carbon::create($currentYear, $currentMonth)->monthName }} {{ $currentYear }}</span>
                    <x-action-button href="{{ route('production', ['month' => $currentMonth + 1 > 12 ? 1 : $currentMonth + 1, 'year' => $currentMonth + 1 > 12 ? $currentYear + 1 : $currentYear]) }}" class="text-blue-500 hover:text-blue-700">Next &gt;</x-action-button>
                </div>


                <div class="bg-blue-100/50 rounded-md p-4">
                    <div class="grid grid-cols-7 gap-2 text-center">

                        <div class="header font-semibold">Mon</div>
                        <div class="header font-semibold">Tue</div>
                        <div class="header font-semibold">Wed</div>
                        <div class="header font-semibold">Thu</div>
                        <div class="header font-semibold">Fri</div>
                        <div class="header font-semibold text-red-500">Sat</div>
                        <div class="header font-semibold text-red-500">Sun</div>

                        @php
                            $firstDayOfMonth = Carbon::create($currentYear, $currentMonth, 1);
                            $firstDayOfWeek = $firstDayOfMonth->dayOfWeek; // 0 = Sunday, 1 = Monday, etc.
                            $daysInMonth = $firstDayOfMonth->daysInMonth;
                            $emptyDays = $firstDayOfWeek == 0 ? 6 : $firstDayOfWeek - 1;
                        @endphp

                        @for ($i = 0; $i < $emptyDays; $i++)
                            <div class="day"></div>
                        @endfor

                        @foreach (range(1, $daysInMonth) as $dayNumber)
                            @php
                                $day = Carbon::create($currentYear, $currentMonth, $dayNumber);
                                $isInProductionRange = in_array($day->toDateString(), $datesInRange);

                                $dayOrders = [];

                                foreach ($prodOrders as $prodOrder) {
                                    if ($prodOrder->start_date && Carbon::parse($prodOrder->start_date)->lte($day) &&
                                        (!$prodOrder->end_date || Carbon::parse($prodOrder->end_date)->gte($day))) {

                                        if (!in_array($prodOrder->id, array_column($dayOrders, 'id'))) {
                                            $dayOrders[] = $prodOrder;
                                        }
                                    }
                                }

                                $dayOrderColors = [];
                                foreach ($dayOrders as $prodOrder) {
                                    $dayOrderColors[] = $orderColors[$prodOrder->id] ?? 'bg-gray-100';
                                }
                            @endphp

                            <div class="day p-4 border border-gray-300 rounded-lg
                                {{ $day->dayOfWeek == 6 || $day->dayOfWeek == 0 ? 'text-red-500' : '' }}
                                {{ $isInProductionRange || !empty($dayOrderColors) ? 'bg-blue-200' : '' }} hover:bg-gray-200">

                                <span class="font-bold">{{ $day->day }}</span>

                                @foreach ($dayOrders as $prodOrder)
                                <div class="order {{ $orderColors[$prodOrder->id] ?? 'bg-gray-100' }} p-2 mt-2 rounded-lg shadow-sm">
                                    <div class="text-xs">
                                        Order: {{ $prodOrder->id }}<br>
                                        Batch: {{ $prodOrder->batch }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endforeach


                    </div>
                </div>

                <x-forms.divider/>

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
                        @php
                            $colorClass = $orderColors[$prodOrder->id] ?? 'bg-gray-100';
                        @endphp
                        <tr class="border-b {{ $colorClass }}">
                            <td class="p-2">
                                <a href="/production/{{ $prodOrder->id }}" class="text-blue-800">{{ $prodOrder->id }}</a>
                            </td>
                            <td class="p-2 dark:text-white">{{ $prodOrder->batch }}</td>
                            <td class="p-2 dark:text-white">
                                {{ $prodOrder->state == 0 ? 'Not Started' : ($prodOrder->state == 1 ? 'In Progress' : 'Completed') }}
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
