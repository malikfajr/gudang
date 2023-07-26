<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::all();

        return view('admin.barang.index', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.barang.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'min:3'],
            'foto' => ['required', 'file', 'image', 'mimes:png,jpg,jpeg'], 
            'harga' => ['required', 'numeric', 'min:1'],
            'stock' => ['required', 'numeric', 'min:1'],
            'deskripsi' => ['required'],
        ]);


        $validated['foto'] = $request->file('foto')->store('barang');

        Barang::create($validated);

        return redirect()->route('barang.index')->with('status', 'created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barang = Barang::findOrFail($id);

        return view('admin.barang.form', compact('barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'nama' => ['required', 'min:3'],
            'foto' => ['sometimes', 'file', 'image', 'mimes:png,jpg,jpeg'], 
            'harga' => ['required', 'numeric', 'min:1'],
            'stock' => ['required', 'numeric', 'min:1'],
            'deskripsi' => ['required'],
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('barang');
        }

        $barang->update($validated);

        return redirect()->route('barang.index')->with('status', 'created');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);

        Storage::delete($barang->foto);
        $barang->delete();

        return redirect()->route('barang.index')->with('status', 'deleted');
    }
}
