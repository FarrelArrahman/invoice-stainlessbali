<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Enums\TransactionEnum;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Income;
use App\Models\IncomeDetail;
use App\Models\Item;
use Illuminate\Http\Request;
use PDF;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomes = Income::all();
        return view('admin.incomes.index', [
            'incomes' => $incomes
        ]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        //
    }
}
