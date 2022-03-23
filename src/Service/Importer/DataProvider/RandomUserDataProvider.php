<?php

namespace App\Service\Importer\DataProvider;

use App\Service\Importer\Contract\DataProviderInterface;
use App\Service\Importer\CustomerData;
use Generator;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RandomUserDataProvider implements DataProviderInterface
{
    /**
     * Create instance of the random user data provider
     *
     * @param HttpClientInterface
     */
    public function __construct(
        protected HttpClientInterface $client
    ) {}

    /**
     * @see DataProviderInterface
     */
    public function getCustomers(): Generator
    {
        $response = $this->client->request('GET', 'https://randomuser.me/api', [
            'query' => [
                'results' => 100,
                'nat' => 'AU',
                'inc' => implode(',', [
                    'gender',
                    'login',
                    'name',
                    'phone',
                    'location',
                    'email',
                ]),
            ],
        ]);

        $list = $response->toArray();

        foreach ($list as $data) {
            yield new CustomerData(
                $data['email'],
                $data['login']['username'],
                $data['login']['password'],
                $data['name']['first'],
                $data['name']['last'],
                $data['gender'],
                $data['location']['country'],
                $data['location']['city'],
                $data['phone']
            );
        }
    }
}