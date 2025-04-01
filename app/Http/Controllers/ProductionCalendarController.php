<?php

namespace App\Http\Controllers;

use App\Models\ProductionOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductionCalendarController extends Controller
{
    public function index(Request $request, $month = null, $year = null)
    {
        $currentMonth = $this->validateMonth($month ?? $request->input('month', now()->month));
        $currentYear = (int)($year ?? $request->input('year', now()->year));

        $orders = $this->getOrdersForMonth($currentYear, $currentMonth);

        return view('production.calendar', [
            'prodOrders' => $orders,
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear,
            'datesInRange' => $this->getActiveProductionDates($orders, $currentYear, $currentMonth)
        ]);
    }

    private function validateMonth($month): int
    {
        $month = (int)$month;
        return ($month >= 1 && $month <= 12) ? $month : now()->month;
    }

    private function getOrdersForMonth(int $year, int $month)
    {
        $monthStart = Carbon::create($year, $month, 1)->startOfMonth();
        $monthEnd = Carbon::create($year, $month, 1)->endOfMonth();

        return ProductionOrder::where('start_date', '<=', $monthEnd)
            ->where(function($query) use ($monthStart) {
                $query->where('end_date', '>=', $monthStart)
                    ->orWhereNull('end_date');
            })
            ->get();
    }

    private function getActiveProductionDates($orders, $year, $month)
    {
        $dates = [];
        $monthStart = Carbon::create($year, $month, 1)->startOfMonth();
        $monthEnd = Carbon::create($year, $month, 1)->endOfMonth();

        foreach ($orders as $order) {
            $start = Carbon::parse($order->start_date);
            $end = $order->end_date ? Carbon::parse($order->end_date) : now();

            $current = max($start, $monthStart);
            $endDate = min($end, $monthEnd);

            while ($current <= $endDate) {
                $dates[] = $current->toDateString();
                $current->addDay();
            }
        }

        return array_unique($dates);
    }

    public function updateState(Request $request, $orderId)
    {
        $validated = $request->validate([
            'state' => 'required|in:0,1,2'
        ]);

        $order = ProductionOrder::findOrFail($orderId);
        $order->state = $validated['state'];
        $order->save();

        return redirect('/production');
    }
}
