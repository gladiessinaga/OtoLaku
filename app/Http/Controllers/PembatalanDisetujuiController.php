<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembatalan;

class PembatalanDisetujuiController extends Controller
{
    // PembatalanController.php

public function approved()
{
    $pembatalans = Pembatalan::with(['pemesanan.mobil', 'pemesanan.user'])
        ->where('status', 'disetujui')
        ->get();

    return view('admin.pembatalan-disetujui', compact('pembatalans'));
}

public function prosesRefund(Request $request, $id)
{
    $request->validate([
        'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $pembatalan = Pembatalan::findOrFail($id);

    if ($request->hasFile('bukti_transfer')) {
        $file = $request->file('bukti_transfer');
        $path = $file->store('bukti-transfer', 'public');

        $pembatalan->bukti_transfer = $path;
        $pembatalan->refund_status = 'sudah';
        $pembatalan->save();
    }
    // dd('masuk prosesRefund');

    return redirect()->back()->with('success', 'Refund berhasil diproses dan bukti transfer disimpan.');
}

}
