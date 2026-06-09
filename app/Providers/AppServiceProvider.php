<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\KartuTertelan; // Tambahkan ini jika belum ada
use App\Observers\KartuObserver; // Tambahkan ini

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
        // Daftarkan observer di sini
        KartuTertelan::observe(KartuObserver::class);
    }
}