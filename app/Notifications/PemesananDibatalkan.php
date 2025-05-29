<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PemesananDibatalkan extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($pemesanan)
    {
        $this->pemesanan = $pemesanan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        return (new MailMessage)
                    ->subject('Notifikasi Pembatalan Pemesanan')
                    ->greeting('Halo Admin,')
                    ->line('Ada pembatalan pemesanan dari user: ' . $this->pemesanan->user->name)
                    ->line('Mobil: ' . $this->pemesanan->mobil->nama)
                    ->line('Tanggal sewa: ' . $this->pemesanan->tanggal_sewa)
                    ->action('Lihat Detail', url(route('admin.pemesanan.detail', $this->pemesanan->id)))
                    ->line('Terima kasih telah menggunakan aplikasi kami.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'pemesanan_id' => $this->pemesanan->id,
            'user_name' => $this->pemesanan->user->name,
            'mobil_nama' => $this->pemesanan->mobil->nama,
            'tanggal_sewa' => $this->pemesanan->tanggal_sewa,
            'message' => 'Ada pembatalan pemesanan dari user ' . $this->pemesanan->user->name,
        ];
    }
    
}
