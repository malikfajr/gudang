<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\History;
use App\Models\Pinjam;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PinjamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $barang = Barang::findOrFail($id);

        return view('user.pinjam.form', compact('barang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $validated = $request->validate([
            'qty' => ['required', 'numeric', 'min:1'],
            'starting_date' => ['required', 'date', 'after_or_equal:date'],
            'ending_date' => ['required', 'date', 'after_or_equal:starting_date'],
        ]);

        $start = new DateTime($validated['starting_date']);
        $end = new DateTime($validated['ending_date']);
        $days = $start->diff($end)->format('%a');

        $validated['total_harga'] = $validated['qty'] * $days * $barang->harga;

        $validated['barang_id'] = $id;
        $validated['user_id'] = auth()->user()->id;
        $validated['status'] = 'diajukan';

        DB::transaction(function () use ($barang, $validated) {
            if ($validated['qty'] > $barang->stock) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'qty' => 'qty not valid value, please check stock'
                ]);
            }

            // $barang->stock -= $validated['qty'];
            // $barang->save();

            Pinjam::create($validated);
            History::create($validated);
        });

        return redirect()->route('dashboard')->with('success', 'Peminjaman telah diajukan');


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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:dibatalkan,dikembalikan',
        ]);

        $pinjam = Pinjam::findOrFail($id);

        DB::transaction(function() use ($pinjam, $validated) {
            if ($pinjam->status == 'diajukan' && $validated['status'] == 'dibatalkan') {
                $pinjam->status = 'dibatalkan';
            } {
                throw ValidationException::withMessages(['error' => 'Data tidak valid']);
            }
            $pinjam->save();

            // $barang = Barang::findOrFail($pinjam->barang_id);
            // $barang->stock += $pinjam->qty;
            // $barang->save();
            
            $this->writeHistory($pinjam);
        });

        return redirect()->route('dashboard')->with('success', 'Berhasil mengubah data');
    }

    private function writeHistory(Pinjam $pinjam) : void {
        History::create([
                'user_id' => $pinjam->user_id,
                'admin_name' => auth()->user()->name,
                'barang_id' => $pinjam->barang_id,
                'qty' => $pinjam->qty,
                'status' => $pinjam->status,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pinjam = Pinjam::findOrFail($id);

        if ($pinjam->status != 'diajukan') {
            return redirect()->route('dashboard')->with('failed', 'Peminjaman barang sudah tidak bisa dibatalkan');
        }

        DB::transaction(function() use ($pinjam) {
            $pinjam->status = 'dibatalkan';
            $pinjam->save();

            $barang = Barang::findOrFail($pinjam->barang_id);
            $barang->stock += $pinjam->qty;
            $barang->save();

            $fileds = [
                'user_id' => auth()->user()->id, 
                'barang_id' => $pinjam->barang_id, 
                'qty' => $pinjam->qty, 
                'status' => $pinjam->status
            ];
            History::create($fileds);
            
            return redirect()->route('dashboard');
        });
    }
}
