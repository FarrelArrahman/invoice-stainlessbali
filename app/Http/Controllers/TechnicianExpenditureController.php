<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Enums\TransactionEnum;
use App\Models\Company;
use App\Models\TechnicianExpenditure;
use App\Models\TechnicianExpenditureDetail;
use App\Models\Item;
use App\Models\Technician;
use Illuminate\Http\Request;

class TechnicianExpenditureController extends Controller
{
    public function index()
    {
        // $technicianExpenditures = TechnicianExpenditure::all();
        // return view('admin.technician_expenditures.index', [
        //     'technician_expenditures' => $technicianExpenditures
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::all();        
        $technicians = Technician::where('status', StatusEnum::Active)->get();

        return view('admin.technician_expenditures.create', [
            'items' => $items,
            'technicians' => $technicians,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $technicianExpenditureData = [
            'technician_id' => $request->technician_id,
            'total_price' => $request->total_price,
            'service_fee' => str_replace('.', '', $request->service_fee),
            'handled_by' => NULL,
            'date' => $request->date,
            'status' => TransactionEnum::Paid,
        ];

        if($request->technician_id == NULL) {
            $technicianData = [
                'name' => $request->technician_name,
                'address' => $request->technician_address,
                'phone_number' => $request->technician_phone_number,
                'status' => StatusEnum::Active,
            ];
    
            $technician = Technician::create($technicianData);

            $technicianExpenditureData['technician_id'] = $technician->id;
        }

        $technicianExpenditure = TechnicianExpenditure::create($technicianExpenditureData);

        foreach($request->breakdown[1]['item'] as $item) {
            $technicianExpenditureDetail = [
                'technician_expenditure_id' => $technicianExpenditure->id,
                'item_name' => $item['name'],
                'price' => str_replace('.', '', $item['price']),
                'qty' => $item['qty'],
                'status' => "",
            ];

            TechnicianExpenditureDetail::create($technicianExpenditureDetail);
        }

        return to_route('expenditures.index')
            ->with('message', "Berhasil menambahkan pengeluaran teknisi baru.")
            ->with('status', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(TechnicianExpenditure $technicianExpenditure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TechnicianExpenditure $technicianExpenditure)
    {
        $technicians = Technician::where('status', StatusEnum::Active)->get();

        return view('admin.technician_expenditures.edit', [
            'technicians' => $technicians,
            'technician_expenditure' => $technicianExpenditure,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TechnicianExpenditure $technicianExpenditure)
    {
        // dd($request->all());

        $technicianExpenditureDetailIds = [];

        $technicianExpenditureData = [
            'technician_id' => $request->technician_id,
            'total_price' => $request->total_price,
            'service_fee' => str_replace('.', '', $request->service_fee),
            'handled_by' => NULL,
            'date' => $request->date,
            'status' => TransactionEnum::Paid,
        ];

        $technicianExpenditure->update($technicianExpenditureData);

        if( ! empty($request->technician_expenditure) ) {
            foreach($request->technician_expenditure as $item) {
                $technicianExpenditureDetailIds[] = $item['id'];

                $technicianExpenditure->items->find($item['id'])->update([
                    'technician_expenditure_id' => $technicianExpenditure->id,
                    'item_name' => $item['name'],
                    'price' => str_replace('.', '', $item['price']),
                    'qty' => $item['qty'],
                    'status' => "",
                ]);
            }
        }

        foreach($technicianExpenditure->items->whereNotIn('id', $technicianExpenditureDetailIds) as $deletedItem) {
            $deletedItem->delete();
        }

        if( ! empty($request->new_item) ) {
            foreach($request->new_item[1]['item'] as $newItem) {
                $technicianExpenditureDetail = [
                    'technician_expenditure_id' => $technicianExpenditure->id,
                    'item_name' => $newItem['name'],
                    'price' => str_replace('.', '', $newItem['price']),
                    'qty' => $newItem['qty'],
                    'status' => "",
                ];
    
                TechnicianExpenditureDetail::create($technicianExpenditureDetail);
            }
        }


        return to_route('expenditures.index')
            ->with('message', "Berhasil mengubah data pengeluaran teknisi.")
            ->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TechnicianExpenditure $technicianExpenditure)
    {
        foreach($technicianExpenditure->items as $item) {
            $item->delete();
        }

        $technicianExpenditure->delete();

        return to_route('expenditures.index')
            ->with('message', "Berhasil menghapus pengeluaran teknisi.")
            ->with('status', 'success');
    }
}
