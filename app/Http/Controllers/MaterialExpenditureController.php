<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Enums\TransactionEnum;
use App\Models\Company;
use App\Models\MaterialExpenditure;
use App\Models\MaterialExpenditureDetail;
use App\Models\Item;
use Illuminate\Http\Request;

class MaterialExpenditureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materialExpenditures = MaterialExpenditure::all();
        return view('admin.material_expenditures.index', [
            'materialExpenditures' => $materialExpenditures
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::all();        
        $companies = Company::where('status', StatusEnum::Active)->get();

        return view('admin.material_expenditures.create', [
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

        $materialExpenditureData = [
            'shop_name' => $request->shop_name,
            'shop_address' => $request->shop_address,
            'shop_telephone_number' => $request->shop_telephone_number,
            'total_price' => $request->total_price,
            'handled_by' => NULL,
            'date' => $request->date,
            'status' => TransactionEnum::Paid,
        ];

        $materialExpenditure = MaterialExpenditure::create($materialExpenditureData);

        foreach($request->breakdown[1]['item'] as $item) {
            $materialExpenditureDetail = [
                'material_expenditure_id' => $materialExpenditure->id,
                'item_name' => $item['item_name'],
                'price' => str_replace('.', '', $item['price']),
                'qty' => $item['qty'],
                'status' => "",
            ];

            MaterialExpenditureDetail::create($materialExpenditureDetail);
        }

        return to_route('expenditures.index')
            ->with('message', "Berhasil menambahkan pengeluaran bahan baru.")
            ->with('status', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(MaterialExpenditure $materialExpenditure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaterialExpenditure $materialExpenditure)
    {
        return view('admin.material_expenditures.edit', [
            'material_expenditures' => $materialExpenditure,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaterialExpenditure $materialExpenditure)
    {
        // dd($request->all());

        $materialExpenditureDetailIds = [];

        $materialExpenditureData = [
            'shop_name' => $request->shop_name,
            'shop_address' => $request->shop_address,
            'shop_telephone_number' => $request->shop_telephone_number,
            'total_price' => $request->total_price,
            'handled_by' => NULL,
            'date' => $request->date,
            'status' => TransactionEnum::Paid,
        ];

        $materialExpenditure->update($materialExpenditureData);

        foreach($request->material_expenditure as $item) {
            $materialExpenditureDetailIds[] = $item['id'];

            $materialExpenditure->items->find($item['id'])->update([
                'material_expenditure_id' => $materialExpenditure->id,
                'item_name' => $item['item_name'],
                'price' => str_replace('.', '', $item['price']),
                'qty' => $item['qty'],
                'status' => "",
            ]);
        }

        foreach($materialExpenditure->items->whereNotIn('id', $materialExpenditureDetailIds) as $deletedItem) {
            $deletedItem->delete();
        }

        if( ! empty($request->new_item) ) {
            foreach($request->new_item as $newItem) {
                $materialExpenditureDetail = [
                    'material_expenditure_id' => $materialExpenditure->id,
                    'item_name' => $newItem['item_name'],
                    'price' => str_replace('.', '', $newItem['price']),
                    'qty' => $newItem['qty'],
                    'status' => "",
                ];
    
                MaterialExpenditureDetail::create($materialExpenditureDetail);
            }
        }


        return to_route('expenditures.index')
            ->with('message', "Berhasil mengubah data pengeluaran bahan.")
            ->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaterialExpenditure $materialExpenditure)
    {
        foreach($materialExpenditure->items as $item) {
            $item->delete();
        }

        $materialExpenditure->delete();

        return to_route('expenditures.index')
            ->with('message', "Berhasil menghapus pengeluaran bahan.")
            ->with('status', 'success');
    }
}
