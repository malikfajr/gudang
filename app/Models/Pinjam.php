<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjam extends Model
{
    use HasFactory;
    
    protected $table = 'pinjam';

    protected $fillable = [
        'user_id',
        'admin_id',
        'barang_id',
        'qty',
        'starting_date',
        'ending_date',
        'status',
    ];
}
