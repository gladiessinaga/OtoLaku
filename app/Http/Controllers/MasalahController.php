<?php

namespace App\Http\Controllers;

use App\Models\Masalah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\LaporanMasalah;

class MasalahController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'admin') {
        $laporan = LaporanMasalah::all(); // admin lihat semua laporan
        return view('admin.laporan-masalah.index', compact('laporan'));
    } else {
        return view('user.lapor-masalah'); // user isi form laporan
    }
    }

    public function kirim(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
     $path = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('laporan-masalah', 'public');
        }

        return redirect()->route('user.lapor-masalah')->with('success', 'Laporan berhasil dikirim!');
    }

    public function create()
    {
        return view('user.lapor-masalah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('laporan_foto', 'public');
        }

        LaporanMasalah::create([
            'user_id' => Auth::id(),
            'deskripsi' => $request->deskripsi,
            'foto' => $path,
        ]);

     return redirect()->route('lapor.create')->with('success', 'Laporan berhasil dikirim!');
}

public function kirimLaporan(Request $request)
{
    $request->validate([
        'deskripsi' => 'required|string',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $path = null;
    if ($request->hasFile('foto')) {
        $path = $request->file('foto')->store('laporan_foto', 'public');
    }

    LaporanMasalah::create([
        'user_id' => auth()->id(),
        'deskripsi' => $request->deskripsi,
        'foto' => $path,
    ]);

    return back()->with('success', 'Laporan telah dikirim ke admin.');
}
}
