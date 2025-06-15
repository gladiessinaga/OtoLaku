<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil;

class MobilController extends Controller
{
    public function userDashboard()
    {
         $user = auth()->user();
            if ($user->role === 'admin') {
                return view('admin.dashboard'); // resources/views/admin/dashboard.blade.php
            } elseif ($user->role === 'user') {
                return view('user.dashboard'); // resources/views/user/dashboard.blade.php
            } else {
                abort(403); // akses ditolak kalau role tidak dikenal
        }
    }
    public function index()
    {
        $mobils = Mobil::take(10)->get(); // Ambil 10 mobil pertama
        return view('user/dashboard.blade.php', compact('mobils')); // arahkan ke view milik user
    }

    // Tampilkan detail mobil
    public function show($id)
    {
        $mobil = Mobil::findOrFail($id);
        return view('user.mobil.show', compact('mobil'));
    }

    // Form atau halaman pemesanan
    public function pesan($id)
    {
        $mobil = Mobil::findOrFail($id);
        return view('user.mobil.pesan', compact('mobil'));
    }

    public function store(Request $request)
{
    // Validasi
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'harga' => 'required|numeric',
        'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'deskripsi' => 'required|string',
        'fasilitas' => 'required|string',
    ]);

    // Upload foto
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->storeAs('public', $filename);
    }

    // Simpan data
    $mobil = new Mobil();
    $mobil->nama = $validated['nama'];
    $mobil->harga = $validated['harga'];
    $mobil->foto = $filename ?? null;
    $mobil->deskripsi = $validated['deskripsi'];
    $mobil->fasilitas = $validated['fasilitas'];
    $mobil->save();

    // Redirect dengan pesan sukses
    return redirect()->route('admin.mobil.create')->with('success', 'Mobil berhasil ditambahkan!');
}


}
