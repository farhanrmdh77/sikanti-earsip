<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Tambahkan ini
use Illuminate\Support\Facades\Schema; // Tambahkan ini
use App\Pengaturan; // Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    public function register() { }

    public function boot()
    {
        // Pastikan tabelnya ada agar tidak error saat instalasi pertama kali
        if (Schema::hasTable('pengaturans')) {
            // Bagikan variabel $app_setting ke SELURUH file blade
            View::share('app_setting', Pengaturan::first());
        }
    }
}