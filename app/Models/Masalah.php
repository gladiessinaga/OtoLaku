<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masalah extends Model
{
    use HasFactory;

    protected $fillable = ['user_id',
        'deskripsi',
        'foto',]; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}