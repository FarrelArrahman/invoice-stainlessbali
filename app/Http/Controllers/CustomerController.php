<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Company;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('admin.customers.index', [
            'customers' => $customers
        ]);
    }

    /**
     * Display a listing of the resource as JSON.
     */
    public function getCustomers()
    {
        $customers = Customer::all();
        return response()->json([
            'success' => true,
            'message' => "Daftar pelanggan",
            'data' => $customers
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        return view('admin.customers.create', [
            'companies' => $companies
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'company_id' => $request->company_id,
        ];

        Customer::create($data);

        return to_route('customers.index')
            ->with('message', "Berhasil menambahkan customer baru.")
            ->with('status', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $companies = Company::all();
        return view('admin.customers.edit', [
            'companies' => $companies,
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'company_id' => $request->company_id,
        ];

        $customer->update($data);

        return to_route('customers.index')
            ->with('message', "Berhasil memperbarui data customer.")
            ->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return to_route('customers.index')
            ->with('message', "Berhasil menghapus data customer.")
            ->with('status', 'success');
    }
}
