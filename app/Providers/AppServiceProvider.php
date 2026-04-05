<?php

namespace App\Providers;

use App\Models\ContentBlock;
use App\Models\Media;
use App\Models\Page;
use App\Models\User;
use App\Observers\AuditLogObserver;
use Illuminate\Support\ServiceProvider;

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
        // Register AuditLog observer for models
        Page::observe(AuditLogObserver::class);
        ContentBlock::observe(AuditLogObserver::class);
        Media::observe(AuditLogObserver::class);
        User::observe(AuditLogObserver::class);
    }
}
