<?php

namespace App\Http\Controllers;

use App\Enums\TransactionEnum;
use App\Models\Transaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Setting;
use App\Models\TransactionBreakdown;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use DataTables;
use PDF;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::latest()->get();
        return view('admin.transactions.index', [
            'transactions' => $transactions
        ]);
    }

    public function getTransactions(Request $request)
    {
        $invoices = Transaction::all();

        if( ! empty($request->start_date) && ! empty($request->end_date) ) {
            $data = $invoices->whereBetween('date', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59'])->sortByDesc('date');
        } else {
            $data = $invoices->whereBetween('date', [today()->startOfMonth()->format('Y-m-d') . ' 00:00:00', today()->endOfMonth()->format('Y-m-d') . ' 23:59:59'])->sortByDesc('date');
        }

        return DataTables::of($data)
            ->addColumn('action', function($row) {
                $action = '<form action="' . route('transactions.destroy', $row->id) . '" method="POST">';
                $action .= '<input type="hidden" name="_token" value="' . csrf_token() . '"><input type="hidden" name="_method" value="DELETE">';
                $action .= '<a href="' . route('transactions.show', $row->code) . '" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>';
                $action .= '<a href="' . route('transactions.edit', $row->id) . '" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>';
                $action .= '<button onclick="return confirm(\'Apakah anda yakin ingin menghapus data ini?\')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                $action .= '</form>';
                return $action;
            })
            ->addColumn('customer_name', function($row) {
                return $row->customer->name;
            })
            ->addColumn('total_price', function($row) {
                return $row->formatted_total_price;
            })
            ->editColumn('date', function($row) {
                return $row->date->format('Y-m-d H:i:s');
            })
            ->rawColumns(['action', 'badge'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::all();        
        $customers = Customer::all();  
        $setting = Setting::first();

        return view('admin.transactions.create', [
            'items' => $items,
            'customers' => $customers,
            'setting' => $setting,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        // dd($request->all());
        // dd(is_file($request->breakdown[1]['item'][2]['image']));

        $code = date('ymdHis');
        // $note = Setting::first()->value;

        $transactionData = [
            'code' => $code,
            'handled_by' => NULL,
            'date' => now(),
            'total_price' => $request->total_price_before_discount,
            'dp' => $request->dp,
            'discount_nominal' => $request->discount_nominal,
            'discount_percentage' => $request->discount_percentage,
            'payment_terms' => $request->payment_terms,
            'status' => TransactionEnum::Unpaid,
            'invoice_type' => $request->invoice_type,
            'note' => str_replace('${down_payment}', number_format($request->dp, 0, '', '.'), $request->note)
        ];

        if(empty($request->customer_id)) {
            if( ! empty($request->name)) {
                $customer = Customer::create([
                    'name' => $request->name,
                    'address' => $request->address ?? "-",
                    'phone_number' => $request->phone_number ?? "-",
                    'status' => 'Active'
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
                        'image' => ! empty($item['image']) && is_file($item['image']) 
                            ? ($item['image'])->store('public/items') 
                            : NULL,
                        'name' => $item['name'],
                        'brand' => $item['brand'],
                        'model' => $item['model'],
                        'width' => $item['width'],
                        'depth' => $item['depth'],
                        'height' => $item['height'],
                        'price' => str_replace('.', '', $item['price']),
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
    public function show($transaction)
    {
        $transaction = Transaction::whereCode($transaction)->first();
        // return view('admin.transactions.pdf', ['transaction' => $transaction]);
        $pdf = PDF::loadView('admin.transactions.pdf', ['transaction' => $transaction]);

        return $pdf->stream('invoice-' . $transaction->code . '.pdf');
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
