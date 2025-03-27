<?php

namespace App\Http\Controllers;

use App\Models\ProductionOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductionCalendarController extends Controller
{
    public function index(Request $request)
    {
        $currentMonth = $request->get('month', Carbon::now()->month);
        $currentYear = $request->get('year', Carbon::now()->year);

        $prodOrders = ProductionOrder::whereYear('start_date', $currentYear)
            ->whereMonth('start_date', $currentMonth)
            ->orWhereMonth('end_date', $currentMonth)
            ->get();

        $orderColors = [];
        foreach ($prodOrders as $prodOrder) {
            $orderColors[$prodOrder->id] = $this->generateOrderColor($prodOrder);
        }

        $firstDayOfMonth = Carbon::create($currentYear, $currentMonth, 1);
        $daysInMonth = $firstDayOfMonth->daysInMonth;

        $days = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $days[] = Carbon::create($currentYear, $currentMonth, $i);
        }

        $datesInRange = [];


        foreach ($prodOrders as $prodOrder) {
            $startDate = Carbon::parse($prodOrder->start_date);
            $endDate = $prodOrder->sale ? Carbon::parse($prodOrder->end_date) : Carbon::now();

            if ($startDate->month == $currentMonth || ($endDate && $endDate->month == $currentMonth)) {
                $datesInRange = array_merge($datesInRange, $this->getDaysInRange($startDate, $endDate));
            }
        }

        return view('production.calendar', compact('days', 'prodOrders', 'currentMonth', 'currentYear', 'datesInRange', 'orderColors'));
    }

    private function getDaysInRange(Carbon $startDate, Carbon $endDate)
    {
        $dates = [];
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $dates[] = $currentDate->toDateString();
            $currentDate->addDay();
        }

        return $dates;
    }

    private function generateOrderColor($prodOrder)
    {
        $colors = ['bg-red-200', 'bg-green-200', 'bg-yellow-200', 'bg-orange-200'];

        return $colors[$prodOrder->id % count($colors)];
    }
}
