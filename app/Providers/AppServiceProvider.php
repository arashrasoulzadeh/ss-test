<?php

namespace App\Providers;

use App\Repositories\AccountRepository;
use App\Repositories\CardRepository;
use App\Repositories\IAccountRepository;
use App\Repositories\ICardRepository;
use App\Repositories\ITransactionRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->bind(IAccountRepository::class, AccountRepository::class);
        app()->bind(ICardRepository::class, CardRepository::class);
        app()->bind(ITransactionRepository::class, TransactionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
