<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Pemesanan</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
    </style>
</head>
<body>
    <h2>Invoice Pemesanan Mobil</h2>
    <p><strong>Nama Mobil:</strong> {{ $pemesanan->mobil->nama }}</p>
    <p><strong>Tanggal Sewa:</strong> {{ $pemesanan->tanggal_sewa }}</p>
    <p><strong>Durasi:</strong> {{ $pemesanan->durasi }} hari</p>
    <p><strong>Opsi Sopir:</strong> {{ ucfirst($pemesanan->opsi_sopir) }}</p>
    <p><strong>Pengambilan:</strong> {{ ucfirst($pemesanan->pengambilan) }}</p>
    <p><strong>Metode Pembayaran:</strong> {{ ucfirst($pemesanan->metode_pembayaran) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($pemesanan->status) }}</p>

    <br><br>
    <p>Terima kasih telah melakukan pemesanan.</p>
</body>
</html>
