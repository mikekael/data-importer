<?php

namespace App\Providers;

use App\Services\Importer\Contracts\DataProvider;
use App\Services\Importer\DataProviders\RandomUserDataProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ImportServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(DataProvider::class, RandomUserDataProvider::class);
    }

    /**
     * @inheritDoc
     */
    public function provides()
    {
        return [
            DataProvider::class,
        ];
    }
}