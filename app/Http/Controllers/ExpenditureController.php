<?php

namespace App\Http\Controllers;

use App\Models\EmployeeExpenditure;
use App\Models\MaterialExpenditure;
use App\Models\OperationalExpenditure;
use App\Models\TechnicianExpenditure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class ExpenditureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.expenditures.index');
    }

    public function getExpenditures(Request $request)
    {
            $expenditures = collect();
            $technicianExpenditures = TechnicianExpenditure::all();
            $employeeExpenditures = EmployeeExpenditure::all();
            $operationalExpenditures = OperationalExpenditure::all();
            $materialExpenditures = MaterialExpenditure::all();

            foreach($technicianExpenditures as $technicianExpenditure) {
                $expenditures->push($technicianExpenditure);
            }
            
            foreach($employeeExpenditures as $employeeExpenditure) {
                $expenditures->push($employeeExpenditure);
            }
            
            foreach($operationalExpenditures as $operationalExpenditure) {
                $expenditures->push($operationalExpenditure);
            }
            
            foreach($materialExpenditures as $materialExpenditure) {
                $expenditures->push($materialExpenditure);
            }

            if( ! empty($request->start_date) && ! empty($request->end_date) ) {
                $data = $expenditures->whereBetween('date', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59'])->sortByDesc('date');
            } else {
                $data = $expenditures->sortByDesc('date');
            }

            return DataTables::of($data)
                ->addColumn('action', function($row) {
                    $action = '<form action="' . $row->delete_route() . '" method="POST"><input type="hidden" name="_token" value="' . csrf_token() . '"><input type="hidden" name="_method" value="DELETE"><a href="' . $row->edit_route() . '" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a><button onclick="return confirm(\'Apakah anda yakin ingin menghapus data ini?\')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></form>';
                    return $action;
                })
                ->addColumn('name', function($row) {
                    if($row instanceof \App\Models\TechnicianExpenditure) {
                        $name = $row->technician->name;
                    } else if($row instanceof \App\Models\EmployeeExpenditure) {
                        $name = $row->employee->name;
                    } else {
                        $name = $row->shop_name;
                    }
                    
                    return $name;
                })
                ->addColumn('type', function($row) {
                    return $row->type;
                })
                ->addColumn('expenditure_type', function($row) {
                    return $row->badge();
                })
                ->addColumn('total_price', function($row) {
                    return $row->formatted_total_price;
                })
                ->editColumn('date', function($row) {
                    return $row->date->format('Y-m-d');
                })
                ->rawColumns(['action', 'expenditure_type'])
                ->make(true);
    }

    public function getExpenditureReport(Request $request)
    {
        $labels = [];
        $data = [];

        if( ! empty($request->year) && ! empty($request->month) ) {
            $expenditure = DB::raw("SELECT YEAR, SUM(total_price) FROM (
                SELECT YEAR(DATE) year, SUM(service_fee + total_price) AS total_price FROM technician_expenditures
                GROUP BY YEAR(DATE)
                UNION
                SELECT YEAR(DATE) year, SUM(working_day * salary_per_day) AS total_price FROM employee_expenditures
                GROUP BY YEAR(DATE)
                UNION
                SELECT YEAR(DATE) YEAR, SUM(total_price) FROM operational_expenditures
                GROUP BY YEAR(DATE)
                UNION
                SELECT YEAR(DATE) YEAR, SUM(total_price) FROM material_expenditures
                GROUP BY YEAR(DATE)
            ) AS T
            WHERE year = 2022
            GROUP BY year");
            
            for($i = 0; $i < Carbon::now()->month($request->month)->daysInMonth; $i++) {
                $labels[] = Carbon::now()->month($request->month)->day($i + 1)->format('d-m-Y');
                $data[] = Expenditure::selectRaw('date(date), sum(total_price) data')
                    ->groupBy('date')
                    ->orderBy('date', 'asc')
                    ->where('date', Carbon::createFromDate($request->year, $request->month, $i + 1)->format('Y-m-d'))
                    ->first()->data ?? 0;
            }

        } else if( ! empty($request->year) && empty($request->month) ) {
            $expenditure = Expenditure::selectRaw('year(date) year, month(date) month, monthname(date) name, sum(total_price) data')
                ->groupBy('year')
                ->groupBy('month')
                ->groupBy('name')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->whereYear('date', $request->year);

                for($i = 1; $i <= 12; $i++) {
                    $labels[] = Carbon::now()->month($i)->isoFormat('MMMM');
                    $data[] = Expenditure::selectRaw('month(date) month, sum(total_price) data')
                        ->groupBy('month')
                        ->orderBy('month', 'asc')
                        ->whereRaw("month(date) = {$i} and year(date) = {$request->year}")
                        ->first()->data ?? 0;
                }
        } else {
            $expenditure = DB::table()->raw("SELECT YEAR, SUM(total_price) FROM (
                SELECT YEAR(DATE) year, SUM(service_fee + total_price) AS total_price FROM technician_expenditures
                GROUP BY YEAR(DATE)
                UNION
                SELECT YEAR(DATE) year, SUM(working_day * salary_per_day) AS total_price FROM employee_expenditures
                GROUP BY YEAR(DATE)
                UNION
                SELECT YEAR(DATE) YEAR, SUM(total_price) FROM operational_expenditures
                GROUP BY YEAR(DATE)
                UNION
                SELECT YEAR(DATE) YEAR, SUM(total_price) FROM material_expenditures
                GROUP BY YEAR(DATE)
            ) AS T
            WHERE year = 2022
            GROUP BY year");
            dd($expenditure);

            $labels = $expenditure->pluck('name');
            $data = $expenditure->pluck('data');
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
