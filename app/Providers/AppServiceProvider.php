<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Pembatalan;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
        // Hitung jumlah permintaan pembatalan yang belum disetujui
        $pendingCount = Pembatalan::where('status', 'pending')->count();

        $view->with('pendingPembatalanCount', $pendingCount);
    });
    }
}
