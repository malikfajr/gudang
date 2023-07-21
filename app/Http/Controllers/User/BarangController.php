<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index() {
        $barang = Barang::where('stock', '>', 0)
            ->get();

        return view('user.barang.index', compact('barang'));
    }
}
