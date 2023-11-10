<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Enums\TransactionEnum;
use App\Models\Company;
use App\Models\Income;
use App\Models\IncomeDetail;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomes = Income::all()->sortByDesc('date');
        return view('admin.incomes.index', [
            'incomes' => $incomes
        ]);
    }

    public function getIncomes(Request $request)
    {
        $incomes = Income::all();

        if( ! empty($request->start_date) && ! empty($request->end_date) ) {
            $data = $incomes->whereBetween('date', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59'])->sortByDesc('date');
        } else {
            $data = $incomes->whereBetween('date', [today()->startOfMonth()->format('Y-m-d') . ' 00:00:00', today()->endOfMonth()->format('Y-m-d') . ' 23:59:59'])->sortByDesc('date');
        }

        return DataTables::of($data)
            ->addColumn('action', function($row) {
                $action = '<form action="' . route('incomes.destroy', $row->id) . '" method="POST"><input type="hidden" name="_token" value="' . csrf_token() . '"><input type="hidden" name="_method" value="DELETE"><a href="' . route('incomes.edit', $row->id) . '" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a><button onclick="return confirm(\'Apakah anda yakin ingin menghapus data ini?\')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></form>';
                return $action;
            })
            ->addColumn('badge', function($row) {
                return $row->status->badge();
            })
            ->addColumn('total_price', function($row) {
                return $row->formatted_total_price;
            })
            ->editColumn('date', function($row) {
                return $row->date->format('Y-m-d');
            })
            ->rawColumns(['action', 'badge'])
            ->make(true);
    }

    public function getIncomeReport(Request $request)
    {
        $labels = [];
        $data = [];

        if( ! empty($request->year) && ! empty($request->month) ) {
            $income = Income::selectRaw('date(date), sum(total_price) data')
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->where('date', Carbon::createFromDate($request->year, $request->month, 2)->format('Y-m-d'))
                ->first();
            
            for($i = 0; $i < Carbon::now()->month($request->month)->daysInMonth; $i++) {
                $labels[] = Carbon::now()->month($request->month)->day($i + 1)->format('d-m-Y');
                $data[] = Income::selectRaw('date(date), sum(total_price) data')
                    ->groupBy('date')
                    ->orderBy('date', 'asc')
                    ->where('date', Carbon::createFromDate($request->year, $request->month, $i + 1)->format('Y-m-d'))
                    ->first()->data ?? 0;
            }

        } else if( ! empty($request->year) && empty($request->month) ) {
            $income = Income::selectRaw('year(date) year, month(date) month, monthname(date) name, sum(total_price) data')
                ->groupBy('year')
                ->groupBy('month')
                ->groupBy('name')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->whereYear('date', $request->year);

                for($i = 1; $i <= 12; $i++) {
                    $labels[] = Carbon::now()->month($i)->isoFormat('MMMM');
                    $data[] = Income::selectRaw('month(date) month, sum(total_price) data')
                        ->groupBy('month')
                        ->orderBy('month', 'asc')
                        ->whereRaw("month(date) = {$i} and year(date) = {$request->year}")
                        ->first()->data ?? 0;
                }
        } else {
            $income = Income::selectRaw('year(date) name, sum(total_price) data')
                ->groupBy('name')
                ->orderBy('name', 'asc');

            $labels = $income->pluck('name');
            $data = $income->pluck('data');
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
        $items = Item::all();        
        $companies = Company::where('status', StatusEnum::Active)->get();

        return view('admin.incomes.create', [
            'items' => $items,
            'companies' => $companies,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $incomeData = [
            'company_name' => $request->company_name,
            'customer_name' => $request->customer_name,
            'company_telephone_number' => $request->company_telephone_number,
            'customer_phone_number' => $request->customer_phone_number,
            'address' => $request->address,
            'status' => $request->status,
            'total_price' => $request->total_price,
            'handled_by' => NULL,
            'date' => $request->date,
            'status' => TransactionEnum::Paid,
        ];

        $income = Income::create($incomeData);

        foreach($request->breakdown[1]['item'] as $item) {
            $incomeDetail = [
                'income_id' => $income->id,
                'name' => $item['name'],
                'price' => str_replace('.', '', $item['price']),
                'qty' => $item['qty'],
                'status' => "",
            ];

            IncomeDetail::create($incomeDetail);
        }

        return to_route('incomes.index')
            ->with('message', "Berhasil menambahkan pemasukan baru.")
            ->with('status', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Income $income)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Income $income)
    {
        $items = Item::all();        
        $companies = Company::where('status', StatusEnum::Active)->get();

        return view('admin.incomes.edit', [
            'items' => $items,
            'companies' => $companies,
            'income' => $income,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income)
    {
        // dd($request->all());

        $incomeDetailIds = [];

        $incomeData = [
            'company_name' => $request->company_name,
            'customer_name' => $request->customer_name,
            'company_telephone_number' => $request->company_telephone_number,
            'customer_phone_number' => $request->customer_phone_number,
            'address' => $request->address,
            'status' => $request->status,
            'total_price' => $request->total_price,
            'handled_by' => NULL,
            'date' => $request->date,
            'status' => TransactionEnum::Paid,
        ];

        $income->update($incomeData);

        foreach($request->income as $item) {
            $incomeDetailIds[] = $item['id'];

            $income->items->find($item['id'])->update([
                'income_id' => $income->id,
                'name' => $item['name'],
                'price' => str_replace('.', '', $item['price']),
                'qty' => $item['qty'],
                'status' => "",
            ]);
        }

        foreach($income->items->whereNotIn('id', $incomeDetailIds) as $deletedItem) {
            $deletedItem->delete();
        }

        if( ! empty($request->new_item) ) {
            foreach($request->new_item as $newItem) {
                $incomeDetail = [
                    'income_id' => $income->id,
                    'name' => $newItem['name'],
                    'price' => str_replace('.', '', $newItem['price']),
                    'qty' => $newItem['qty'],
                    'status' => "",
                ];
    
                IncomeDetail::create($incomeDetail);
            }
        }


        return to_route('incomes.index')
            ->with('message', "Berhasil mengubah data pemasukan.")
            ->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        foreach($income->items as $item) {
            $item->delete();
        }

        $income->delete();

        return to_route('incomes.index')
            ->with('message', "Berhasil menghapus pemasukan.")
            ->with('status', 'success');
    }
}
