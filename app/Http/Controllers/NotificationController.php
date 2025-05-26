<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    // Tampilkan halaman notifikasi
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->latest()->get();

        if ($user->role === 'admin') {
            return view('admin.notifikasi', compact('notifications'));
        } else {
            return view('user.notifikasi', compact('notifications'));
        }
    }

    // Tandai satu notifikasi sudah dibaca
    public function markAsRead($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back();
    }

    // Tandai semua notifikasi sudah dibaca
    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return redirect()->back();
    }

    
}
