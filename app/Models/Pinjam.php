<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pinjam extends Model
{
    use HasFactory;
    
    protected $table = 'pinjam';

    protected $fillable = [
        'user_id',
        'barang_id',
        'qty',
        'uang_muka',
        'total_harga',
        'denda',
        'starting_date',
        'ending_date',
        'status',
    ];

    public function barang() {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getStartingDateAttribute ($value) {
        return (new Carbon($value))->locale('id')->translatedFormat('l, d F Y');
    }

    public function getEndingDateAttribute ($value) {
        return (new Carbon($value))->locale('id')->translatedFormat('l, d F Y');
    }

    public function getSisaBayarAttribute () {
        return $this->total_harga - $this->uang_muka;
    }

    public function getIncomeAttribute () {
        if ($this->status == 'dipinjam') {
            return $this->uang_muka;
        };

        if ($this->status == 'dikembalikan') {
            return $this->total_harga + $this->denda;
        }

        return 0;
    }
}
