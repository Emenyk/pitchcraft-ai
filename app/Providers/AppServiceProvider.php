<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\AI\Tools\MatchSkillsTool;
use App\Services\AIService;
use App\Services\ProposalService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AIService::class);
        $this->app->singleton(MatchSkillsTool::class);
        $this->app->singleton(ProposalService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
