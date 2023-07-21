<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pinjam;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $pinjam = Pinjam::query();

        if (! auth()->user()->is_admin) {
            $pinjam->where('user_id', auth()->user()->id);
        } else {
            $pinjam->where('status', '!=', 'dibatalkan');
        }

        $pinjam->orderBy('created_at', 'desc');

        return view('dashboard', [
            'pinjam' => $pinjam->get(),
        ]);
    }
}
