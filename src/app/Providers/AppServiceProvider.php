<?php

namespace App\Providers;

use App\Repositories\Contracts\AuthRepositoryInterface;
use App\Repositories\Contracts\StudentRepositoryInterface;
use App\Repositories\Eloquent\AuthEloquentRepository;
use App\Repositories\Eloquent\StudentEloquentRepository;
use App\Services\Student\StudentService;
use App\Services\Student\StudentServiceInterface;
use App\Services\Auth\AuthService;
use App\Services\Auth\AuthServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthRepositoryInterface::class,AuthEloquentRepository::class);
        $this->app->bind(StudentRepositoryInterface::class,StudentEloquentRepository::class);
        $this->app->bind(AuthServiceInterface::class,AuthService::class);
        $this->app->bind(StudentServiceInterface::class,StudentService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
