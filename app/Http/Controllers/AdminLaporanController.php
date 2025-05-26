<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masalah;
use App\Models\LaporanMasalah;  

class AdminLaporanController extends Controller
{
    public function index()
    {
        $laporan = LaporanMasalah::with('user')->latest()->get(); 
        return view('admin.laporan-masalah.index', compact('laporan'));
    }

    public function laporanMasalah()
{
    $laporan = LaporanMasalah::with('user')->latest()->get();
    return view('admin.laporan-masalah', compact('laporan'));
}
}
