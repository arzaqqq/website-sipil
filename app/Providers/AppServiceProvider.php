<?php

namespace App\Providers;



use Illuminate\View\View;
use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use App\Filament\Resources\SoalResource;
use Filament\Support\Facades\FilamentView;

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
    public function boot()
    {
        FilamentView::registerRenderHook(
            'panels::auth.login.form.after',
            fn(): View => view('filament.login_extra')
        );
        require_once base_path('app/helpers.php');
    }
}
