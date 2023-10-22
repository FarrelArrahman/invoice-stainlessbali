<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\Company;
use App\Models\Customer;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all();
        return view('admin.companies.index', [
            'companies' => $companies
        ]);
    }

    /**
     * Display a listing of the resource as JSON.
     */
    public function getCompanies()
    {
        $companies = Company::all();
        return response()->json([
            'success' => true,
            'message' => "Daftar perusahaan",
            'data' => $companies
        ], 200);
    }

    /**
     * Display a listing of the resource as JSON.
     */
    public function getCompanyCustomers($company)
    {
        if($company == 0) {
            $customers = Customer::where('status', StatusEnum::Active)->get();
        } else {
            $company = Company::find($company);
            $customers = $company->customers;
        }
        
        return response()->json([
            'success' => true,
            'message' => "Daftar customer perusahaan",
            'data' => $customers
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'telephone_number' => $request->telephone_number,
            'status' => StatusEnum::Active,
        ];

        Company::create($data);

        return to_route('companies.index')
            ->with('message', "Berhasil menambahkan data perusahaan baru.")
            ->with('status', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('admin.companies.edit', [
            'company' => $company
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'telephone_number' => $request->telephone_number,
            'status' => StatusEnum::tryFrom($request->status),
        ];

        $company->update($data);

        return to_route('companies.index')
            ->with('message', "Berhasil mengubah data perusahaan.")
            ->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return to_route('companies.index')
            ->with('message', "Berhasil menghapus data perusahaan.")
            ->with('status', 'success');
    }
}
