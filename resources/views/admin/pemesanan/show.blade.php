@extends('layouts.admin')

@section('content')
<div class="p-4">
    <h2 class="text-xl font-semibold mb-4">Detail Pesanan</h2>

    <div class="mb-4">
        <strong>Nama User:</strong> {{ $pemesanan->user->name }} <br>
        <strong>Mobil:</strong> {{ $pemesanan->mobil->nama }} <br>
        <strong>Tanggal Sewa:</strong> {{ $pemesanan->tanggal_sewa }} <br>
        <strong>Durasi:</strong> {{ $pemesanan->durasi }} hari <br>
        <strong>Status:</strong> {{ $pemesanan->status }} <br>
        <strong>Catatan:</strong> {{ $pemesanan->catatan ?? '-' }} <br>
    </div>

    @if ($pemesanan->status !== 'terverifikasi')
    <form action="{{ route('admin.pemesanan.verifikasi', $pemesanan->id) }}" method="POST">
        @csrf
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Verifikasi Pesanan</button>
    </form>
    @else
    <div class="text-green-700 font-semibold">
        Pesanan sudah terverifikasi.
    </div>
    @endif

    <a href="{{ route('admin.pesanan') }}" class="text-blue-600 underline mt-4 inline-block">Kembali ke daftar pesanan</a>
</div>
@endsection
