<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
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
    Route::middleware('web')
        ->group(base_path('routes/web.php'));

    // Daftarkan alias middleware 'admin'
    Route::aliasMiddleware('admin', IsAdmin::class);
}
}
