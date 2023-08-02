<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\History;
use App\Models\Pinjam;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PinjamController extends Controller
{
    public function prosesPeminjaman(Request $request, $id)  {
        $validated = $request->validate([
            'uang_muka' => 'required_if:status,dipinjam|numeric',
            'status' => 'required|in:dipinjam,ditolak,dikembalikan',
        ]);

        $pinjam = Pinjam::findOrFail($id);
        if ($pinjam->status == 'ditolak') {
            return redirect()->back();
        }

        DB::transaction(function() use ($pinjam, $validated) {

            if ($pinjam->status == 'diajukan') {
                if ($validated['status'] == 'dipinjam') {
                    $pinjam->uang_muka = $validated['uang_muka'];

                    $barang = Barang::findOrFail($pinjam->barang_id);
                    $barang->stock -= $pinjam->qty;
                    $barang->save();
                }
            } elseif ($pinjam->status == 'dipinjam' && $validated['status'] == 'dikembalikan') {
                $barang = Barang::findOrFail($pinjam->barang_id);
                $barang->stock += $pinjam->qty;
                $barang->save();

                $now = new DateTime();
                $deadline = Carbon::parseFromLocale($pinjam->ending_date, 'id')->toDateTime();
                $diff_days = $deadline->diff($now)->format('%R%a');
                if ($diff_days > 0) {
                    $pinjam->denda = $diff_days * 500; // 500 harga denda per hari
                }
            } else {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'error' => 'Status not valid'
                ]);
            }
            $pinjam->status = $validated['status'];
            $pinjam->save();
            
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

    public function show($id) {
        $pinjam = Pinjam::findOrFail($id);
        $barang = $pinjam->barang;

        $now = new DateTime();
        $deadline = Carbon::parseFromLocale($pinjam->ending_date, 'id')->toDateTime();
        $diff_days = $deadline->diff($now)->format('%R%a');
        $denda = 0;
        if ($diff_days > 0) {
            $denda = $diff_days * 500; // 500 harga denda per hari
        }
        
        return view('admin.pinjam.show', compact('pinjam', 'barang', 'denda'));
    }
}
