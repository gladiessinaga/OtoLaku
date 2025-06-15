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
        'status_pengembalian',
        'kondisi_bbm_kembali',
        'denda_bbm',
        'tanggal_sewa_terakhir',
        'alamat_pengantaran',
        'no_hp',
        'status_verifikasi_denda_bbm',
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

    public function pembatalan()
{
    return $this->hasOne(Pembatalan::class);
}

public function pengembalian()
{
    return $this->hasOne(Pengembalian::class);
}

public function filePerjanjian()
{
    return $this->hasOne(\App\Models\FilePerjanjian::class, 'pemesanan_id');
}


}
