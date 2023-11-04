<?php

namespace App\Http\Controllers;

use App\Models\EmployeeExpenditure;
use App\Models\MaterialExpenditure;
use App\Models\OperationalExpenditure;
use App\Models\TechnicianExpenditure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;

class ExpenditureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

        $sorted = $expenditures->sortByDesc('date');

        return view('admin.expenditures.index', [
            'expenditures' => $sorted->values()->all()
        ]);
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
