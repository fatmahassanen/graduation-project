<?php

namespace App\Providers;

use App\Models\ContentBlock;
use App\Models\Media;
use App\Models\Page;
use App\Policies\ContentBlockPolicy;
use App\Policies\MediaPolicy;
use App\Policies\PagePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Page::class => PagePolicy::class,
        ContentBlock::class => ContentBlockPolicy::class,
        Media::class => MediaPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
