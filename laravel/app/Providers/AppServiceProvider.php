<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Policies\NotePolicy;
use App\Models\Note;
use Illuminate\Support\Facades\Gate;

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
        Gate::policy(Note::class, NotePolicy::class);
    }
}
