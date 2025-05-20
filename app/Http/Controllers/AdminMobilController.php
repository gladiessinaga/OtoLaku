<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil;

class AdminMobilController extends Controller
{
    public function index()
    {
        $mobils = Mobil::all();
        $jumlahPemesananBaru = 0;
        return view('admin.dashboard', compact('mobils', 'jumlahPemesananBaru'));
    }

    public function create()
    {
        return view('admin.mobil.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'fasilitas' => 'required|string',
            'foto' => 'required|image|max:2048'
        ]);

        $fotoPath = $request->file('foto')->store('mobil', 'public');

        Mobil::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'fasilitas' => $request->fasilitas,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('admin.mobil.index')->with('success', 'Mobil berhasil ditambahkan');
    }

    public function edit(Mobil $mobil)
    {
        return view('admin.mobil.edit', compact('mobil'));
    }

    public function update(Request $request, Mobil $mobil)
    {
        $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'fasilitas' => 'required|string',
            'foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('mobil', 'public');
            $mobil->foto = $fotoPath;
        }

        $mobil->update($request->only(['nama', 'deskripsi', 'harga', 'fasilitas']));
        return redirect()->back()->with('success', 'Mobil berhasil diupdate');
    }

    public function destroy(Mobil $mobil)
    {
        $mobil->delete();
        return redirect()->route('admin.mobil.index')->with('success', 'Mobil berhasil dihapus');
    }

    

    
}
