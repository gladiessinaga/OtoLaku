<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Pembatalan;

class PembatalanMasukNotification extends Notification
{
    use Queueable;

    protected $pembatalan;

    public function __construct(Pembatalan $pembatalan)
    {
        $this->pembatalan = $pembatalan;
    }

    public function via($notifiable)
    {
        return ['database'];  // menyimpan notifikasi ke database
    }

    public function toDatabase($notifiable)
    {
        return [
            'pembatalan_id' => $this->pembatalan->id,
            'pemesanan_id' => $this->pembatalan->pemesanan_id,
            'pesan' => 'Ada pembatalan baru dengan alasan: ' . $this->pembatalan->alasan,
            'waktu' => now(),
        ];
    }
}
