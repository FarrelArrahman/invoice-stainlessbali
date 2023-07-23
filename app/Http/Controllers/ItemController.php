<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();
        return view('admin.items.index', [
            'items' => $items
        ]);
    }

    /**
     * Display a listing of the resource as JSON.
     */
    public function getItems()
    {
        $items = Item::all();
        return response()->json([
            'success' => true,
            'message' => "Daftar item",
            'data' => $items
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request)
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
            'image' => $request->file('image')->store('public/items'),
        ];

        Item::create($data);

        return to_route('items.index')
            ->with('message', "Berhasil menambahkan item baru.")
            ->with('status', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        return view('admin.items.edit', [
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, Item $item)
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
            $data['image'] = $request->file('image')->store('public/items');
        }

        $item->update($data);

        return to_route('items.index')
            ->with('message', "Berhasil memperbarui data item.")
            ->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return to_route('items.index')
            ->with('message', "Berhasil menghapus data item.")
            ->with('status', 'success');
    }
}
