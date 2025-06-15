<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemesanan_id',
        'metode',
        'status',
        'bukti_pembayaran',
        'jumlah',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }
}
