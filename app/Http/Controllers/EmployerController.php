<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    public function index()
    {
        $employees = Employer::with('line')->get();
        return view('employees.index', [
            'employees' => $employees,
        ]);
    }
    public function show(Employer $employer)
    {
        return view('employees.show', [
            'employer' => $employer,
            'line' =>$employer->line,
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

        $employer = Employer::create($attributes);

        return redirect('/employees');
    }
    public function destroy(Employer $employer)
    {
        $employer->delete();
        return redirect('/employees');
    }

}
