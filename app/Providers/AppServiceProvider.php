<?php

namespace App\Providers;

use App\Models\Order;
use App\Observers\OrderObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        // Menyuntikkan variabel secara global ke SEMUA halaman Blade sebelum di-render
        View::composer('*', function ($view) {
            // 1. Ambil bahasa dari URL, jika kosong ambil dari session
            $lang = request()->query('locale') ?? session('locale') ?? 'en';
            
            // 2. Simpan ke session agar halaman lain ingat
            session(['locale' => $lang]);

            // 3. Load file common.json
            $common = json_decode(@file_get_contents(public_path('translation/common.json')), true) ?? [];

            // 4. Bagikan variabel secara paksa ke seluruh Blade
            $view->with([
                'lang' => $lang,
                'common' => $common
            ]);
        });
        // Register Order Observer for push notifications
        Order::observe(OrderObserver::class);
    }
}
