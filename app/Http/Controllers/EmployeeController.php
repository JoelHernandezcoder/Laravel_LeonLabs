<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\ProductionLine;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::paginate(10);
        return view('employees.index', [
            'employees' => $employees,
        ]);
    }
    public function show(Employee $employee)
    {
        return view('employees.show', [
            'employee' => $employee,
            'line' => $employee->lines()->first(),
        ]);
    }


    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'gender' => ['required'],
            'address' => ['required'],
            'meal_option' => ['required'],
            'role' => ['required'],
            'seniority' => ['required', 'integer'],
            'salary' => ['required', 'numeric'],
            'start_date' => ['required', 'date'],
        ]);
        $employee = Employee::create($attributes);
        return redirect('/employees');
    }
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect('/employees');
    }

}
