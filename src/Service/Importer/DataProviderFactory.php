<?php

namespace App\Service\Importer;

use App\Service\Importer\Contract\DataProviderFactoryInterface;
use App\Service\Importer\Contract\DataProviderInterface;
use App\Service\Importer\DataProvider\RandomUserDataProvider;
use Symfony\Component\HttpClient\HttpClient;

class DataProviderFactory implements DataProviderFactoryInterface
{
    /**
     * @see DataProviderFactoryInterface
     */
    public function make(?string $providerId = null): DataProviderInterface
    {
        switch ($providerId) {
            case 'randomuser':
            default:
                return $this->makeRandomUserProvider();
        }
    }

    /**
     * Create instance of the random user provider instance
     *
     * @return RandomUserDataProvider
     */
    protected function makeRandomUserProvider(): RandomUserDataProvider
    {
        return new RandomUserDataProvider(
            HttpClient::create()
        );
    }
}