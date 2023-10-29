<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Enums\TransactionEnum;
use App\Models\Employee;
use App\Models\EmployeeExpenditure;
use App\Models\Item;
use App\Models\Technician;
use Illuminate\Http\Request;

class EmployeeExpenditureController extends Controller
{
    public function index()
    {
        $employeeExpenditures = EmployeeExpenditure::all();
        return view('admin.employee_expenditures.index', [
            'employee_expenditures' => $employeeExpenditures
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::where('status', StatusEnum::Active)->get();

        return view('admin.employee_expenditures.create', [
            'employees' => $employees,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        foreach($request->breakdown[1]['item'] as $item) {
            $employeeExpenditure = [
                'employee_id' => $request->employee_id,
                'date' => $request->date,
                'month' => $item['month'],
                'year' => $item['year'],
                'salary_per_day' => str_replace('.', '', $item['salary_per_day']),
                'working_day' => $item['working_day'],
                'status' => TransactionEnum::Paid,
            ];
            
            EmployeeExpenditure::create($employeeExpenditure);
        }

        return to_route('expenditures.index')
            ->with('message', "Berhasil menambahkan data gaji karyawan.")
            ->with('status', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeExpenditure $employeeExpenditure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeExpenditure $employeeExpenditure)
    {
        $employees = Employee::where('status', StatusEnum::Active)->get();

        return view('admin.employee_expenditures.edit', [
            'employees' => $employees,
            'employee_expenditure' => $employeeExpenditure,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeExpenditure $employeeExpenditure)
    {
        // dd($request->all());
        foreach($request->employee_expenditure as $item) {
            $employeeExpenditure->update([
                'employee_id' => $request->employee_id,
                'salary_per_day' => str_replace('.', '', $item['salary_per_day']),
                'working_day' => $item['working_day'],
                'status' => TransactionEnum::Paid,
            ]);
        }


        return to_route('expenditures.index')
            ->with('message', "Berhasil mengubah data gaji karyawan.")
            ->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeExpenditure $employeeExpenditure)
    {
        $employeeExpenditure->delete();

        return to_route('expenditures.index')
            ->with('message', "Berhasil menghapus data gaji karyawan.")
            ->with('status', 'success');
    }
}
