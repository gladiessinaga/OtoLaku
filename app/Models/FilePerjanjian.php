<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilePerjanjian extends Model
{
    use HasFactory;

    protected $fillable = [
    'pemesanan_id',
    'file_path',
];

public function pemesanan()
{
    return $this->belongsTo(\App\Models\Pemesanan::class, 'pemesanan_id');
}

}
