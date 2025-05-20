<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mobil_id',
        'tanggal_sewa',
        'durasi',
        'opsi_sopir',
        'metode_pembayaran',
        'pengambilan',
        'ktp',
        'sim',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id', 'id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

}
