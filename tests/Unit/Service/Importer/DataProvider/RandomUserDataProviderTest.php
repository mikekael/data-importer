<?php

namespace App\Tests\Unit\Service\Importer\DataProvider;

use App\Service\Importer\CustomerData;
use App\Service\Importer\DataProvider\RandomUserDataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class RandomUserDataProviderTest extends TestCase
{
    /**
     * @var MockResponse
     */
    protected MockResponse $response;

    /**
     * @var RandomUserDataProvider
     */
    protected RandomUserDataProvider $provider;

    /**
     * @see TestCase
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new MockResponse(json_encode([
            'results' => [[
                'gender' => 'male',
                'name' => [
                    'first' => 'Terry',
                    'last' => 'Sanchez',
                ],
                'location' => [
                    'country' => 'Australia',
                    'city' => 'Mackay',
                ],
                'login' => [
                    'username' => 'purplemeercat122',
                    'password' => 'jason',
                ],
                'email' => 'terry.sanchez@example.com',
                'phone' => '04-3987-1147',
            ]],
        ]));

        $this->provider = new RandomUserDataProvider(
            new MockHttpClient([$this->response], 'https://randomuser.me/api')
        );
    }

    /**
     * @test
     */
    public function shouldLimitResultTo100(): void
    {
        $this->provider->getCustomers()->next();

        $this->assertEquals('GET', $this->response->getRequestMethod());
        $this->assertStringContainsString('https://randomuser.me/api', $this->response->getRequestUrl());
        $this->assertEquals(100, $this->response->getRequestOptions()['query']['results']);
    }

    /**
     * @test
     */
    public function shouldOnlyImportAustralianNationality(): void
    {
        $this->provider->getCustomers()->next();

        $this->assertEquals('GET', $this->response->getRequestMethod());
        $this->assertStringContainsString('https://randomuser.me/api', $this->response->getRequestUrl());
        $this->assertEquals('AU', $this->response->getRequestOptions()['query']['nat']);
    }

    /**
     * @test
     */
    public function shouldOnlyIncludeVariousFields(): void
    {
        $this->provider->getCustomers()->next();

        $this->assertEquals('GET', $this->response->getRequestMethod());
        $this->assertStringContainsString('https://randomuser.me/api', $this->response->getRequestUrl());
        $this->assertEquals('gender,login,name,phone,location,email', $this->response->getRequestOptions()['query']['inc']);
    }

    /**
     * @test
     */
    public function shouldYieldCustomerData(): void
    {
        /** @var CustomerData */
        $data = $this->provider->getCustomers()->current();

        $this->assertInstanceOf(CustomerData::class, $data);
        $this->assertEquals('terry.sanchez@example.com', $data->getEmail());
        $this->assertEquals('purplemeercat122', $data->getUsername());
        $this->assertEquals('jason', $data->getPlainPassword());
        $this->assertEquals('Terry', $data->getFirstName());
        $this->assertEquals('Sanchez', $data->getLastName());
        $this->assertEquals('male', $data->getGender());
        $this->assertEquals('Australia', $data->getCountry());
        $this->assertEquals('Mackay', $data->getCity());
        $this->assertEquals('04-3987-1147', $data->getPhone());
    }
}
