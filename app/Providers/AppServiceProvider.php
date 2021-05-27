<?php

namespace App\Providers;

use App\Contracts\Domain\CustomerRepository as CustomerRepositoryInterface;
use App\Entities\Customer;
use App\Infrastructure\Hasher\Md5Hasher;
use App\Infrastructure\Repositories\CustomerRepository;
use Doctrine\Persistence\ObjectRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\Configuration\Cache\CacheManager;
use LaravelDoctrine\ORM\Configuration\Cache\IlluminateCacheAdapter;
use LaravelDoctrine\ORM\Facades\EntityManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->overrideDoctrineArrayCacheProvider();
        $this->registerCustomerRepository();
        $this->registerHasher();
    }

    /**
     * Register customer repository implementation to the application container
     *
     * @return void
     */
    protected function registerCustomerRepository(): void
    {
        $this->app->when(CustomerRepository::class)
            ->needs(ObjectRepository::class)
            ->give(fn() => EntityManager::getRepository(Customer::class));

        $this->app->singleton(CustomerRepositoryInterface::class, CustomerRepository::class);
    }

    /**
     * Overrides the default array cache provider of laravel-doctrine which uses the doctrine/common/cache library
     * which is removed in version 3.0 we will make use of the current laravel array cache driver
     *
     * @return void
     */
    protected function overrideDoctrineArrayCacheProvider(): void
    {
        /** @var \LaravelDoctrine\ORM\Configuration\Cache\CacheManager */
        $manager = $this->app->make(CacheManager::class);

        $manager->extend('array', fn() => new IlluminateCacheAdapter(Cache::store('array')));
    }

    /**
     * Register md5 hash driver
     *
     * @return void
     */
    protected function registerHasher(): void
    {
        /** @var \Illuminate\Hashing\HashManager */
        $manager = $this->app->make('hash');

        $manager->extend('md5', fn() => new Md5Hasher);
    }
}
