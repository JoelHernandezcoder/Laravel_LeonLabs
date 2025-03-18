<?php

namespace App\Http\Controllers;

use App\Models\Employee;
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
            'line' =>$employee->line,
        ]);
    }

    public function create()
    {
        return view('employees.create');


    }

    public function store(Request $request)
    {
        $attributes = $request->validate([

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
