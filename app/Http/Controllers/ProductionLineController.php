<?php

namespace App\Http\Controllers;

use App\Models\ProductionLine;
use App\Models\Employee;
use Illuminate\Http\Request;

class ProductionLineController extends Controller
{
    public function index()
    {
        $lines = ProductionLine::all();
        return view('production.lines.index', [
            'lines' => $lines,
        ]);
    }

    public function show(ProductionLine $line)
    {
        $assignedEmployeeIds = \DB::table('production_line_employee')
            ->pluck('employee_id')
            ->toArray();

        return view('production.lines.show', [
            'line' => $line,
            'employees' => $line->employees,
            'allEmployees' => Employee::whereNotIn('id', $assignedEmployeeIds)->get(),
        ]);
    }


    public function addEmployee(ProductionLine $line, Request $request)
    {
        $request->validate([
            'employee' => ['required', 'exists:employees,id'],
        ]);

        $employeeId = $request->input('employee');

        // Verificar si ya está en alguna línea
        $alreadyAssigned = \DB::table('production_line_employee')
            ->where('employee_id', $employeeId)
            ->exists();

        if ($alreadyAssigned) {
            return redirect()->back()->withErrors([
                'employee' => 'This employee is already assigned to another production line.',
            ]);
        }

        // Adjuntar si no está en esta línea (redundante si ya controlás lo anterior)
        if (!$line->employees()->where('employee_id', $employeeId)->exists()) {
            $line->employees()->attach($employeeId);
        }

        return redirect()->back()->with('success', 'Employee added to production line.');
    }


    public function removeEmployee(ProductionLine $line, Employee $employee)
    {
        $line->employees()->detach($employee->id);
        return redirect()->back();
    }
}
