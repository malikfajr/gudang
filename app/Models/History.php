<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class History extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'admin_name',
        'barang_id',
        'qty',
        'date',
        'status',
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id')->withTrashed();
    }

    public function getDateAttribute ($value) {
        return (new Carbon($value))->locale('id')->translatedFormat('l, d F Y');
    }
}
