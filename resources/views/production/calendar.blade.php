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
                <div class="flex justify-between items-center mb-4">
                    <a href="{{ route('calendar', ['month' => $currentMonth - 1 <= 0 ? 12 : $currentMonth - 1, 'year' => $currentMonth - 1 <= 0 ? $currentYear - 1 : $currentYear]) }}" class="text-blue-500 hover:text-blue-700">&lt; Previous</a>
                    <span class="font-bold text-lg">{{ \Carbon\Carbon::create($currentYear, $currentMonth)->monthName }} {{ $currentYear }}</span>
                    <a href="{{ route('calendar', ['month' => $currentMonth + 1 > 12 ? 1 : $currentMonth + 1, 'year' => $currentMonth + 1 > 12 ? $currentYear + 1 : $currentYear]) }}" class="text-blue-500 hover:text-blue-700">Next &gt;</a>
                </div>

                <div class="bg-blue-100/50 rounded-md p-4">
                    <div class="grid grid-cols-7 gap-2 text-center">
                        <div class="header font-semibold text-red-500">Sat</div>
                        <div class="header font-semibold text-red-500">Sun</div>
                        <div class="header font-semibold">Mon</div>
                        <div class="header font-semibold">Tue</div>
                        <div class="header font-semibold">Wed</div>
                        <div class="header font-semibold">Thu</div>
                        <div class="header font-semibold">Fri</div>

                        @foreach ($days as $day)
                            @php
                                $isInProductionRange = in_array($day->toDateString(), $datesInRange);

                                $isAgreedDate = $prodOrders->contains(function ($prodOrder) use ($day) {
                                    return Carbon::parse($prodOrder->sale->agreed_date)->isSameDay($day);
                                });
                            @endphp
                            <div class="day p-4 border border-gray-300 rounded-lg
                            {{ $day->dayOfWeek == 6 || $day->dayOfWeek == 0 ? 'text-red-500' : '' }}
                            {{ $isInProductionRange || $isAgreedDate ? 'bg-blue-200' : '' }} hover:bg-gray-200">
                                <span class="font-bold">{{ $day->day }}</span>
                                @foreach ($prodOrders as $prodOrder)
                                    @if ($prodOrder->created_at->isSameDay($day))
                                        <div class="text-xs mt-1">Order: {{ $prodOrder->batch }}</div>
                                    @endif
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
                <div class="text-center mb-8">
                    <x-action-button href="/lines" >Production Lines</x-action-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
