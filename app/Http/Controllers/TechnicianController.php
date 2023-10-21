<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\Technician;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $technicians = Technician::all();
        return view('admin.technicians.index', [
            'technicians' => $technicians
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.technicians.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'status' => StatusEnum::Active,
        ];

        Technician::create($data);

        return to_route('technicians.index')
            ->with('message', "Berhasil menambahkan data perusahaan baru.")
            ->with('status', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Technician $technician)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Technician $technician)
    {
        return view('admin.technicians.edit', [
            'technician' => $technician
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Technician $technician)
    {
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'status' => StatusEnum::tryFrom($request->status),
        ];

        $technician->update($data);

        return to_route('technicians.index')
            ->with('message', "Berhasil mengubah data perusahaan.")
            ->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technician $technician)
    {
        $technician->delete();
        return to_route('technicians.index')
            ->with('message', "Berhasil menghapus data perusahaan.")
            ->with('status', 'success');
    }
}
