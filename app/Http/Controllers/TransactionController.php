<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Enums\TransactionEnum;
use App\Models\Transaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Customer;
use App\Models\Item;
use App\Models\TransactionBreakdown;
use App\Models\TransactionItem;
use Illuminate\Support\Str;

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
        // dd($request->all());

        $transactionData = [
            'code' => date('ymdhis') . Str::upper(Str::random(6)),
            'handled_by' => NULL,
            'date' => now(),
            'total_price' => $request->total_price_before_discount,
            'dp' => $request->dp,
            'discount_nominal' => $request->discount_nominal,
            'discount_percentage' => $request->discount_percentage,
            'payment_terms' => $request->payment_terms,
            'status' => TransactionEnum::Unpaid,
            'note' => ''
        ];

        if(empty($request->customer_id)) {
            if( ! empty($request->name)) {
                $customer = Customer::create([
                    'name' => $request->name,
                    'address' => $request->address ?? "-",
                    'phone_number' => $request->phone_number ?? "-",
                ]);

                $transactionData['customer_id'] = $customer->id;
            }
        } else {
            $transactionData['customer_id'] = $request->customer_id;
        }

        $transaction = Transaction::create($transactionData);

        $breakdownCounter = 1;
        if( ! empty($request->breakdown)) {
            foreach($request->breakdown as $breakdown) {
                if( empty($breakdown['item'])) {
                    continue;
                }

                $transactionBreakdown = TransactionBreakdown::create([
                    'transaction_id' => $transaction->id,
                    'breakdown_name' => $breakdown['name'] ?? "Breakdown #" . $breakdownCounter
                ]);

                foreach($breakdown['item'] as $item) {
                    $breakdownItemData = [
                        'transaction_breakdown_id' => $transactionBreakdown->id,
                        'item_id' => $item['id'] ?? NULL,
                        'image' => $item['id'] == null ? ($item['image'])->store('public/items') : $item['image'],
                        'description' => $item['name'],
                        'brand' => $item['brand'],
                        'model' => $item['model'],
                        'width' => $item['width'],
                        'depth' => $item['depth'],
                        'height' => $item['height'],
                        'price' => $item['price'],
                        'qty' => $item['qty'],
                        'status' => "",
                    ];

                    TransactionItem::create($breakdownItemData);
                }
            }
        }

        return to_route('transactions.index')
            ->with('message', "Berhasil menambahkan transaksi baru.")
            ->with('status', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        // dd($transaction->breakdowns);
        
        $items = Item::all();        
        $customers = Customer::all();  

        return view('admin.transactions.edit', [
            'items' => $items,
            'customers' => $customers,
            'transaction' => $transaction,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        return to_route('transactions.index')
            ->with('message', "Berhasil memperbarui data invoice.")
            ->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        foreach($transaction->breakdowns as $breakdown) {
            foreach($breakdown->items as $item) {
                $item->delete();
            }
            $breakdown->delete();
        }
        $transaction->delete();

        return to_route('transactions.index')
            ->with('message', "Berhasil menghapus invoice.")
            ->with('status', 'success');
    }
}
