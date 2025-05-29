<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanMasalah extends Model
{
    use HasFactory;

    protected $table = 'laporan_masalah';

        protected $fillable = [
        'user_id',
        'deskripsi',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
