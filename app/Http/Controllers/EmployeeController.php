<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employees::paginate(15);
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'FirstName'     => 'required|string|max:30',
            'LastName'      => 'required|string|max:30',
            'MiddleName'    => 'nullable|string|max:30',
            'NameExtension' => 'nullable|string|max:30',
            'DateOfBirth'   => 'required|date',
            'CivilStatus'   => 'required|in:Single,Married,Widowed,Separated',
        ]);

        $validated['created_by'] = auth()->id() ?? 0;
        $validated['updated_by'] = auth()->id() ?? 0;

        Employees::create($validated);

        return redirect()->route('employees.index')->with('success', 'Employee added successfully.');
    }

    public function show(Employees $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(Employees $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employees $employee)
    {
        $validated = $request->validate([
            'FirstName'     => 'required|string|max:30',
            'LastName'      => 'required|string|max:30',
            'MiddleName'    => 'nullable|string|max:30',
            'NameExtension' => 'nullable|string|max:30',
            'DateOfBirth'   => 'required|date',
            'CivilStatus'   => 'required|in:Single,Married,Widowed,Separated',
        ]);

        $validated['updated_by'] = auth()->id() ?? 0;

        $employee->update($validated);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employees $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted.');
    }
}