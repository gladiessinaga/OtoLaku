<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PengembalianUangController extends Controller
{
    public function show($id)
    {
        $pemesanan = Pemesanan::with('mobil')->findOrFail($id);

        // Optional: pastikan status memang dibatalkan
        if ($pemesanan->status !== 'dibatalkan') {
            return redirect()->back()->with('error', 'Pengembalian hanya tersedia untuk pemesanan yang dibatalkan.');
        }

        return view('user.pengembalian-uang', compact('pemesanan'));
    }
}