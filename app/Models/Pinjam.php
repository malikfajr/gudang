<?php

namespace App\Models;

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
}
