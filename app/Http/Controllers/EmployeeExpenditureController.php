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
        dd($request->all());

        foreach($request->breakdown[1]['item'] as $item) {
            $employeeExpenditure = [
                'employee_id' => $request->employee_id,
                'month' => $request->month,
                'year' => $request->year,
                'salary_per_day' => str_replace('.', '', $item['salary_per_day']),
                'working_day' => $item['working_day'],
                'status' => "",
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
        $employees = Technician::where('status', StatusEnum::Active)->get();

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

        $employeeExpenditureDetailIds = [];

        $employeeExpenditureData = [
            'employee_id' => $request->employee_id,
            'total_price' => $request->total_price,
            'service_fee' => str_replace('.', '', $request->service_fee),
            'handled_by' => NULL,
            'date' => $request->date,
            'status' => TransactionEnum::Paid,
        ];

        $employeeExpenditure->update($employeeExpenditureData);

        foreach($request->employee_expenditure as $item) {
            $employeeExpenditureDetailIds[] = $item['id'];

            $employeeExpenditure->items->find($item['id'])->update([
                'employee_expenditure_id' => $employeeExpenditure->id,
                'name' => $item['name'],
                'price' => str_replace('.', '', $item['price']),
                'qty' => $item['qty'],
                'status' => "",
            ]);
        }

        foreach($employeeExpenditure->items->whereNotIn('id', $employeeExpenditureDetailIds) as $deletedItem) {
            $deletedItem->delete();
        }

        if( ! empty($request->new_item) ) {
            foreach($request->new_item as $newItem) {
                $employeeExpenditureDetail = [
                    'employee_expenditure_id' => $employeeExpenditure->id,
                    'name' => $newItem['name'],
                    'price' => str_replace('.', '', $newItem['price']),
                    'qty' => $newItem['qty'],
                    'status' => "",
                ];
    create($employeeExpenditureDetail);
            }
        }


        return to_route('expenditures.index')
            ->with('message', "Berhasil mengubah data pengeluaran teknisi.")
            ->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeExpenditure $employeeExpenditure)
    {
        foreach($employeeExpenditure->items as $item) {
            $item->delete();
        }

        $employeeExpenditure->delete();

        return to_route('expenditures.index')
            ->with('message', "Berhasil menghapus pengeluaran teknisi.")
            ->with('status', 'success');
    }
}
