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
        $prodOrders = ProductionOrder::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->get();
        $firstDayOfMonth = Carbon::create($currentYear, $currentMonth, 1);
        $daysInMonth = $firstDayOfMonth->daysInMonth;

        $days = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $days[] = Carbon::create($currentYear, $currentMonth, $i);
        }

        $datesInRange = [];

        foreach ($prodOrders as $prodOrder) {
            $startDate = $prodOrder->created_at; // Fecha de la orden de producción
            $endDate = $prodOrder->sale ? Carbon::parse($prodOrder->sale->agreed_date) : null; // La fecha agreed_date de la venta

            if ($endDate) {
                $datesInRange = array_merge($datesInRange, $this->getDaysInRange($startDate, $endDate));
            }
        }
        return view('production.calendar', compact('days', 'prodOrders', 'currentMonth', 'currentYear', 'datesInRange'));
    }


    private function getDaysInRange($startDate, $endDate)
    {
        $dates = [];
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $dates[] = $currentDate->toDateString();
            $currentDate->addDay();
        }
        return $dates;
    }
}
