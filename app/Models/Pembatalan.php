<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembatalan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemesanan_id', 
        'alasan', 
        'alasan_lain', 
        'status'
    ];

    public function pemesanan()
{
    return $this->belongsTo(Pemesanan::class);
}

}
