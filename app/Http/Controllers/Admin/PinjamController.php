<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\History;
use App\Models\Pinjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PinjamController extends Controller
{
    public function prosesPeminjaman(Request $request, $id)  {
        $validated = $request->validate([
            'status' => 'required|in:dipinjam,ditolak',
        ]);

        $pinjam = Pinjam::findOrFail($id);
        if ($pinjam->status != 'diajukan') {
            return redirect()->back();
        }

        DB::transaction(function() use ($pinjam, $validated) {
            $pinjam->status = $validated['status'];
            $pinjam->save();

            if ($validated['status'] == 'ditolak') {
                $barang = Barang::findOrFail($pinjam->barang_id);
                $barang->stock += $pinjam->qty;
                $barang->save();
            }
            
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
}
