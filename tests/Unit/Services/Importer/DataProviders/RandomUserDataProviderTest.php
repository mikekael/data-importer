<?php

namespace Tests\Unit\Services\Importer\DataProviders;

use App\DTO\CustomerData;
use App\Services\Importer\Contracts\DataProvider;
use App\Services\Importer\DataProviders\RandomUserDataProvider;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

final class RandomUserDataProviderTest extends TestCase
{
    /**
     * @var \App\Services\Importer\DataProviders\RandomUserDataProvider
     */
    protected RandomUserDataProvider $dataProvider;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        Http::fake([
            'randomuser.me/*' => Http::response(['results' => [
                [
                    'gender' => 'male',
                    'name' => [
                        'first' => 'John',
                        'last' => 'Doe',
                    ],
                    'location' => [
                        'country' => 'Philippines',
                        'city' => 'Makati',
                    ],
                    'login' => [
                        'username' => 'johndoe1234',
                        'password' => 'password',
                    ],
                    'email' => 'john@example.org',
                    'phone' => '09221711247',
                ],
            ]]),
        ]);

        $this->dataProvider = new RandomUserDataProvider;
    }

    /**
     * @test
     */
    public function should_implement_data_provider_interface(): void
    {
        $this->assertInstanceOf(DataProvider::class, $this->dataProvider);
    }

    /**
     * @test
     */
    public function should_fetch_100_customers(): void
    {
        collect($this->dataProvider->getCustomers());

        Http::assertSent(function (Request $request) {
            return $request['results'] === 100;
        });
    }

    /**
     * @test
     */
    public function should_fetch_au_nationalities(): void
    {
        collect($this->dataProvider->getCustomers());

        Http::assertSent(function (Request $request) {
            return $request['nat'] === 'AU';
        });
    }

    /**
     * @test
     */
    public function should_only_include_fields(): void
    {
        collect($this->dataProvider->getCustomers());

        Http::assertSent(function (Request $request) {
            return $request['inc'] === 'gender,login,name,phone,location,email';
        });
    }

    /**
     * @test
     */
    public function should_yield_each_customer_data(): void
    {
        /** @var \App\DTO\CustomerData */
        $data = collect($this->dataProvider->getCustomers())->first();

        $this->assertInstanceOf(CustomerData::class, $data);
        $this->assertEquals($data->firstName, 'John');
        $this->assertEquals($data->lastName, 'Doe');
        $this->assertEquals($data->email, 'john@example.org');
        $this->assertEquals($data->username, 'johndoe1234');
        $this->assertEquals($data->password, 'password');
        $this->assertEquals($data->gender, 'male');
        $this->assertEquals($data->country, 'Philippines');
        $this->assertEquals($data->city, 'Makati');
        $this->assertEquals($data->phone, '09221711247');
    }
}