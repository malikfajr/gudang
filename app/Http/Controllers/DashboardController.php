<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\History;
use App\Models\Pinjam;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
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

    public function history() {
        $histories = History::query();

        if (! auth()->user()->is_admin) {
            $histories->where('user_id', auth()->user()->id);
        }
        $histories->orderBy('created_at', 'desc');

        return view('history', [
            'histories' => $histories->get()
        ]);
    }
}
