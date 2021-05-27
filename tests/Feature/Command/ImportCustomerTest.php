<?php

namespace Tests\Feature\Command;

use App\Entities\Customer;
use App\Services\Importer\Contracts\DataProvider;
use Illuminate\Support\Facades\App;
use LaravelDoctrine\Migrations\Testing\DatabaseMigrations;
use LaravelDoctrine\ORM\Testing\Concerns\InteractsWithEntities;
use Tests\Fakes\InMemoryDataProvider;
use Tests\TestCase;

final class ImportCustomerTest extends TestCase
{
    use DatabaseMigrations,
        InteractsWithEntities;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->singleton(DataProvider::class, InMemoryDataProvider::class);
    }

    /**
     * @test
     */
    public function should_import_customers(): void
    {
        $this->artisan('import:customers');

        $this->entitiesMatch(Customer::class, [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john@example.org',
            'username' => 'johndoe1234',
            'password' => md5('password'),
            'gender' => 'male',
            'country' => 'Philippines',
            'city' => 'Makati',
            'phone' => '09221711247'
        ]);
    }

    /**
     * @test
     */
    public function should_update_record_if_already_exists_with_email(): void
    {
        /** @var \App\Entities\Customer */
        $customer = entity(Customer::class)->create([
            'email' => 'john@example.org',
        ]);

        $this->artisan('import:customers');

        $this->entitiesMatch(Customer::class, [
            'id' => $customer->getId(),
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john@example.org',
            'username' => 'johndoe1234',
            'password' => md5('password'),
            'gender' => 'male',
            'country' => 'Philippines',
            'city' => 'Makati',
            'phone' => '09221711247'
        ]);
    }
}