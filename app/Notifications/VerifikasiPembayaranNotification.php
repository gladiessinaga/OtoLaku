<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifikasiPembayaranNotification extends Notification
{
    use Queueable;

    protected $pemesanan;

    public function __construct($pemesanan)
    {
        $this->pemesanan = $pemesanan;
    }

    public function via($notifiable)
    {
        return ['database']; // agar masuk ke tabel notifications
    }

    public function toDatabase($notifiable)
    {
        return [
        'pesan' => 'Pemesanan Anda untuk mobil ' . $this->pemesanan->mobil->nama . ' telah diverifikasi!',
        'pemesanan_id' => $this->pemesanan->id,
        ];
    }

     public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Pembayaran Telah Diverifikasi')
                    ->line('Pembayaran Anda telah berhasil diverifikasi oleh admin.')
                    ->action('Lihat Detail', url('/user/riwayat')) // arahkan ke halaman riwayat user
                    ->line('Terima kasih telah menggunakan layanan kami.');
    }

}
