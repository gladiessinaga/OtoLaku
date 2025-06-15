<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Pemesanan</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #222;
            margin: 30px;
            line-height: 1.5;
        }

        /* KOP SURAT */
        .kop {
            display: flex;
            align-items: center;
            border-bottom: 3px solid #444;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .logo {
            width: 90px;
            height: 90px;
            background-color: #ddd;
            border-radius: 12px;
            margin-right: 25px;
            flex-shrink: 0;
            /* Tempat untuk logo, nanti diganti dengan img */
        }
        .kop-info {
            line-height: 1.2;
        }
        .kop-info h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            color: #007BFF;
        }
        .kop-info p {
            margin: 2px 0;
            font-size: 13px;
            color: #555;
        }

        /* JUDUL */
        h2 {
            font-weight: 700;
            color: #333;
            margin-bottom: 25px;
        }

        /* DATA PEMESANAN */
        .data-pemesanan p {
            margin: 8px 0;
            font-size: 15px;
        }
        .data-pemesanan strong {
            color: #444;
            width: 180px;
            display: inline-block;
        }

        /* CATATAN */
        .footer-note {
            margin-top: 40px;
            font-size: 14px;
            color: #666;
            font-style: italic;
            border-top: 1px solid #eee;
            padding-top: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="kop">
        {{-- <div class="logo">
            <img src="{{ asset('storage/logo.png') }}" alt="Logo Nauli Raptama" style="width:90px; height:90px; border-radius:12px;">
        </div> --}}
        <div class="kop-info">
            <h1>Nauli Raptama</h1>
            <p>Alamat: Jl. Jenderal Sudirman No 385, Kelurahan Kayu Embun</p>
            <p>Kecamatan Padang Sidempuan Utara, Kota Padang Sidempuan</p>
            <p>Telp: +62 821 2358 7938</p>
        </div>
    </div>

    <h2>Invoice Pemesanan Mobil</h2>

    <div class="data-pemesanan">
        <p><strong>Nama Mobil:</strong> {{ $pemesanan->mobil->nama }}</p>
        <p><strong>Tanggal Sewa:</strong> {{ \Carbon\Carbon::parse($pemesanan->tanggal_sewa)->format('d-m-Y') }}</p>
        <p><strong>Durasi:</strong> {{ $pemesanan->durasi }} hari</p>
        <p><strong>Opsi Sopir:</strong> {{ ucfirst($pemesanan->opsi_sopir) }}</p>
        <p><strong>Pengambilan:</strong> {{ ucfirst($pemesanan->pengambilan) }}</p>
        <p><strong>Alamat Pengantaran:</strong> {{ ucfirst($pemesanan->alamat_pengantaran) }}</p>

        @if(strtolower($pemesanan->pengambilan) === 'ambil')
            <p><strong>Alamat Pengambilan:</strong> Jl. Jenderal Sudirman No 385, Kelurahan Kayu Embun, Kecamatan Padang Sidempuan Utara Kota Padang Sidempuan</p>
        @endif

        <p><strong>Metode Pembayaran:</strong> {{ ucfirst($pemesanan->metode_pembayaran) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($pemesanan->status) }}</p>
        <p><strong>No Telepon:</strong> {{ $user->no_hp }}</p>
    </div>

    <div class="footer-note">
        Terima kasih telah melakukan pemesanan di Nauli Raptama.<br>
        Jika ada pertanyaan, silakan hubungi nomor telepon kami di atas.
    </div>

</body>
</html>
