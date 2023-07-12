<?php

namespace App\Providers;

use App\Http\ApiResponses\FailResponse;
use App\Http\ApiResponses\ResponseInterface;
use App\Http\ApiResponses\SuccessResponse;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Services\OrderService;
use App\Http\Services\UserService;
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
        $this->app->when(UserController::class)->give(UserService::class);
        $this->app->when(UserController::class)->needs(ResponseInterface::class)->give(FailResponse::class);
        $this->app->when(UserController::class)->needs(ResponseInterface::class)->give(SuccessResponse::class);

        $this->app->when(OrderController::class)->give(OrderService::class);
        $this->app->when(OrderController::class)->needs(ResponseInterface::class)->give(FailResponse::class);
        $this->app->when(OrderController::class)->needs(ResponseInterface::class)->give(SuccessResponse::class);

    }
}
