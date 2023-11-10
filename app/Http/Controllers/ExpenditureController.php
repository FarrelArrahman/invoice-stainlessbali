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
                $data = $expenditures->whereBetween('date', [today()->startOfMonth()->format('Y-m-d') . ' 00:00:00', today()->endOfMonth()->format('Y-m-d') . ' 23:59:59'])->sortByDesc('date');
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
            $technician_expenditures = DB::table('technician_expenditures')
                ->selectRaw('DATE(DATE) AS date, SUM(service_fee + total_price) AS total_price')
                ->groupByRaw('DATE(DATE)');

            $employee_expenditures = DB::table('employee_expenditures')
                ->selectRaw('DATE(DATE) AS date, SUM(working_day * salary_per_day) AS total_price')
                ->groupByRaw('DATE(DATE)');

            $operational_expenditures = DB::table('operational_expenditures')
                ->selectRaw('DATE(DATE) AS date, SUM(total_price)')
                ->groupByRaw('DATE(DATE)');

            $material_expenditures = DB::table('material_expenditures')
                ->selectRaw('DATE(DATE) AS date, SUM(total_price)')
                ->groupByRaw('DATE(DATE)');

            for($i = 0; $i < Carbon::now()->month($request->month)->daysInMonth; $i++) {
                $labels[] = Carbon::now()->month($request->month)->day($i + 1)->format('d-m-Y');
                $data[] = $expenditure = DB::query()->fromSub(
                    $technician_expenditures
                        ->union($employee_expenditures)
                        ->union($operational_expenditures)
                        ->union($material_expenditures)
                , 't')
                    ->selectRaw('DATE(date) as date, SUM(total_price) as total_price')
                    ->where('date', Carbon::createFromDate($request->year, $request->month, $i + 1)->format('Y-m-d'))
                    ->groupBy('date')
                    ->orderBy('date')
                    ->first()->total_price ?? 0;
            }

        } else if( ! empty($request->year) && empty($request->month) ) {
            $technician_expenditures = DB::table('technician_expenditures')
                ->selectRaw('YEAR(DATE) year, MONTH(DATE) month, SUM(service_fee + total_price) AS total_price')
                ->groupByRaw('MONTH(DATE), YEAR(DATE)');

            $employee_expenditures = DB::table('employee_expenditures')
                ->selectRaw('YEAR(DATE) year, MONTH(DATE) month, SUM(working_day * salary_per_day) AS total_price')
                ->groupByRaw('MONTH(DATE), YEAR(DATE)');

            $operational_expenditures = DB::table('operational_expenditures')
                ->selectRaw('YEAR(DATE) year, MONTH(DATE) month, SUM(total_price)')
                ->groupByRaw('MONTH(DATE), YEAR(DATE)');

            $material_expenditures = DB::table('material_expenditures')
                ->selectRaw('YEAR(DATE) year, MONTH(DATE) month, SUM(total_price)')
                ->groupByRaw('MONTH(DATE), YEAR(DATE)');

                for($i = 1; $i <= 12; $i++) {
                    $labels[] = Carbon::now()->month($i)->isoFormat('MMMM');
                    $data[] = DB::query()->fromSub(
                        $technician_expenditures
                            ->union($employee_expenditures)
                            ->union($operational_expenditures)
                            ->union($material_expenditures)
                    , 't')
                        ->selectRaw('month, year, SUM(total_price) as total_price')
                        ->where('year', $request->year)
                        ->where('month', $i)
                        ->groupBy('month', 'year')
                        ->first()->total_price ?? 0;
                }
        } else {
            $technician_expenditures = DB::table('technician_expenditures')
                ->selectRaw('YEAR(DATE) year, SUM(service_fee + total_price) AS total_price')
                ->groupByRaw('YEAR(DATE)');

            $employee_expenditures = DB::table('employee_expenditures')
                ->selectRaw('YEAR(DATE) year, SUM(working_day * salary_per_day) AS total_price')
                ->groupByRaw('YEAR(DATE)');

            $operational_expenditures = DB::table('operational_expenditures')
                ->selectRaw('YEAR(DATE) year, SUM(total_price)')
                ->groupByRaw('YEAR(DATE)');

            $material_expenditures = DB::table('material_expenditures')
                ->selectRaw('YEAR(DATE) year, SUM(total_price)')
                ->groupByRaw('YEAR(DATE)');

            $expenditure = DB::query()->fromSub(
                $technician_expenditures
                    ->union($employee_expenditures)
                    ->union($operational_expenditures)
                    ->union($material_expenditures)
            , 't')
                ->selectRaw('year, SUM(total_price) as total_price')
                ->groupBy('year')
                ->orderBy('year')
                ->get();

            $labels = $expenditure->pluck('year');
            $data = $expenditure->pluck('total_price');
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    public function getExpenditureComparisonReport(Request $request)
    {
        $labels = ["Teknisi", "Karyawan", "Operasional", "Material"];
        $data = [];

        if( ! empty($request->year) && ! empty($request->month) ) {            
            $technician_expenditures = DB::table('technician_expenditures')
                ->selectRaw('SUM(service_fee + total_price) AS total_price')
                ->whereRaw("YEAR(date) = {$request->year}")
                ->whereRaw("MONTH(date) = {$request->month}")
                ->first();

            $employee_expenditures = DB::table('employee_expenditures')
                ->selectRaw('SUM(working_day * salary_per_day) AS total_price')
                ->whereRaw("YEAR(date) = {$request->year}")
                ->whereRaw("MONTH(date) = {$request->month}")
                ->first();

            $operational_expenditures = DB::table('operational_expenditures')
                ->selectRaw('SUM(total_price) AS total_price')
                ->whereRaw("YEAR(date) = {$request->year}")
                ->whereRaw("MONTH(date) = {$request->month}")
                ->first();

            $material_expenditures = DB::table('material_expenditures')
                ->selectRaw('SUM(total_price) AS total_price')
                ->whereRaw("YEAR(date) = {$request->year}")
                ->whereRaw("MONTH(date) = {$request->month}")
                ->first();

        } else if( ! empty($request->year) && empty($request->month) ) {
            $technician_expenditures = DB::table('technician_expenditures')
                ->selectRaw('SUM(service_fee + total_price) AS total_price')
                ->whereRaw("YEAR(date) = {$request->year}")
                ->first();

            $employee_expenditures = DB::table('employee_expenditures')
                ->selectRaw('SUM(working_day * salary_per_day) AS total_price')
                ->whereRaw("YEAR(date) = {$request->year}")
                ->first();

            $operational_expenditures = DB::table('operational_expenditures')
                ->selectRaw('SUM(total_price) AS total_price')
                ->whereRaw("YEAR(date) = {$request->year}")
                ->first();

            $material_expenditures = DB::table('material_expenditures')
                ->selectRaw('SUM(total_price) AS total_price')
                ->whereRaw("YEAR(date) = {$request->year}")
                ->first();
        } else {
            $technician_expenditures = DB::table('technician_expenditures')
                ->selectRaw('SUM(service_fee + total_price) AS total_price')
                ->first();

            $employee_expenditures = DB::table('employee_expenditures')
                ->selectRaw('SUM(working_day * salary_per_day) AS total_price')
                ->first();

            $operational_expenditures = DB::table('operational_expenditures')
                ->selectRaw('SUM(total_price) AS total_price')
                ->first();

            $material_expenditures = DB::table('material_expenditures')
                ->selectRaw('SUM(total_price) AS total_price')
                ->first();
        }

        $data = [
            $technician_expenditures->total_price ?? 0,
            $employee_expenditures->total_price ?? 0,
            $operational_expenditures->total_price ?? 0,
            $material_expenditures->total_price ?? 0,
        ];

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
