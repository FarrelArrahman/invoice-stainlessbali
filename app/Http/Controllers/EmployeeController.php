<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return view('admin.employees.index', [
            'employees' => $employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'status' => StatusEnum::Active,
        ];

        Employee::create($data);

        return to_route('employees.index')
            ->with('message', "Berhasil menambahkan data perusahaan baru.")
            ->with('status', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', [
            'employee' => $employee
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'status' => StatusEnum::tryFrom($request->status),
        ];

        $employee->update($data);

        return to_route('employees.index')
            ->with('message', "Berhasil mengubah data perusahaan.")
            ->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return to_route('employees.index')
            ->with('message', "Berhasil menghapus data perusahaan.")
            ->with('status', 'success');
    }
}
