<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Customer;
use App\Models\Item;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::all();
        return view('admin.transactions.index', [
            'transactions' => $transactions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::all();        
        $customers = Customer::all();  

        return view('admin.transactions.create', [
            'items' => $items,
            'customers' => $customers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $item)
    {
        return view('admin.transactions.edit', [
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $item)
    {
        $data = [
            'name' => $request->name,
            'brand' => $request->brand ?? "*CUSTOM",
            'model' => $request->model,
            'width' => $request->width,
            'depth' => $request->depth,
            'height' => $request->height,
            'price' => $request->price,
            'status' => StatusEnum::Available,
        ];

        if($request->hasFile('image')) {
            if($item->image != "") {
                Storage::delete($item->image);
            }
            $data['image'] = $request->file('image')->store('public/transactions');
        }

        $item->update($data);

        return to_route('transactions.index')
            ->with('message', "Berhasil memperbarui data item.")
            ->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $item)
    {
        $item->delete();
        return to_route('transactions.index')
            ->with('message', "Berhasil menghapus data item.")
            ->with('status', 'success');
    }
}
