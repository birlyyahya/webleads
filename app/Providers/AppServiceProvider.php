<?php

namespace App\Providers;

use App\Models\HistoryLeads;
use App\Models\Leads;
use App\Policies\LeadPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
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
        Gate::policy(Leads::class, UserPolicy::class);
        Gate::policy(HistoryLeads::class, LeadPolicy::class);
    }
}
