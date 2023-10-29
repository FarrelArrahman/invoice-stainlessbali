<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Enums\TransactionEnum;
use App\Models\Company;
use App\Models\OperationalExpenditure;
use App\Models\OperationalExpenditureDetail;
use App\Models\Item;
use Illuminate\Http\Request;

class OperationalExpenditureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $operationalExpenditures = OperationalExpenditure::all();
        return view('admin.operational_expenditures.index', [
            'operationalExpenditures' => $operationalExpenditures
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::all();        
        $companies = Company::where('status', StatusEnum::Active)->get();

        return view('admin.operational_expenditures.create', [
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

        $operationalExpenditureData = [
            'shop_name' => $request->shop_name,
            'shop_address' => $request->shop_address,
            'shop_telephone_number' => $request->shop_telephone_number,
            'total_price' => $request->total_price,
            'handled_by' => NULL,
            'date' => $request->date,
            'status' => TransactionEnum::Paid,
        ];

        $operationalExpenditure = OperationalExpenditure::create($operationalExpenditureData);

        foreach($request->breakdown[1]['item'] as $item) {
            $operationalExpenditureDetail = [
                'operational_expenditure_id' => $operationalExpenditure->id,
                'item_name' => $item['item_name'],
                'price' => str_replace('.', '', $item['price']),
                'qty' => $item['qty'],
                'status' => "",
            ];

            OperationalExpenditureDetail::create($operationalExpenditureDetail);
        }

        return to_route('expenditures.index')
            ->with('message', "Berhasil menambahkan pengeluaran operasional baru.")
            ->with('status', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(OperationalExpenditure $operationalExpenditure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OperationalExpenditure $operationalExpenditure)
    {
        return view('admin.operational_expenditures.edit', [
            'operational_expenditures' => $operationalExpenditure,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OperationalExpenditure $operationalExpenditure)
    {
        // dd($request->all());

        $operationalExpenditureDetailIds = [];

        $operationalExpenditureData = [
            'shop_name' => $request->shop_name,
            'shop_address' => $request->shop_address,
            'shop_telephone_number' => $request->shop_telephone_number,
            'total_price' => $request->total_price,
            'handled_by' => NULL,
            'date' => $request->date,
            'status' => TransactionEnum::Paid,
        ];

        $operationalExpenditure->update($operationalExpenditureData);

        foreach($request->operational_expenditure as $item) {
            $operationalExpenditureDetailIds[] = $item['id'];

            $operationalExpenditure->items->find($item['id'])->update([
                'operational_expenditure_id' => $operationalExpenditure->id,
                'item_name' => $item['item_name'],
                'price' => str_replace('.', '', $item['price']),
                'qty' => $item['qty'],
                'status' => "",
            ]);
        }

        foreach($operationalExpenditure->items->whereNotIn('id', $operationalExpenditureDetailIds) as $deletedItem) {
            $deletedItem->delete();
        }

        if( ! empty($request->new_item) ) {
            foreach($request->new_item as $newItem) {
                $operationalExpenditureDetail = [
                    'operational_expenditure_id' => $operationalExpenditure->id,
                    'item_name' => $newItem['item_name'],
                    'price' => str_replace('.', '', $newItem['price']),
                    'qty' => $newItem['qty'],
                    'status' => "",
                ];
    
                OperationalExpenditureDetail::create($operationalExpenditureDetail);
            }
        }


        return to_route('expenditures.index')
            ->with('message', "Berhasil mengubah data pengeluaran operasional.")
            ->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OperationalExpenditure $operationalExpenditure)
    {
        foreach($operationalExpenditure->items as $item) {
            $item->delete();
        }

        $operationalExpenditure->delete();

        return to_route('expenditures.index')
            ->with('message', "Berhasil menghapus pengeluaran operasional.")
            ->with('status', 'success');
    }
}
