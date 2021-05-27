<?php

namespace App\Services\Importer\DataProviders;

use App\DTO\CustomerData;
use App\Services\Importer\Contracts\DataProvider;
use Illuminate\Support\Facades\Http;

class RandomUserDataProvider implements DataProvider
{
    /**
     * @var string
     */
    const API_URL = 'https://randomuser.me/api';

    /**
     * @inheritDoc
     *
     * @return \Generator
     */
    public function getCustomers()
    {
        $response = Http::get(static::API_URL, [
            'results' => 100,
            'nat' => 'AU',
            'inc' => implode(',', [
                'gender',
                'login',
                'name',
                'phone',
                'location',
                'email',
            ])
        ]);

        foreach ($response->json('results') as $result) {
            yield new CustomerData([
                'firstName' => $result['name']['first'],
                'lastName' => $result['name']['last'],
                'email' => $result['email'],
                'username' => $result['login']['username'],
                'password' => $result['login']['password'],
                'gender' => $result['gender'],
                'country' => $result['location']['country'],
                'city' => $result['location']['city'],
                'phone' => $result['phone'],
            ]);
        }
    }
}