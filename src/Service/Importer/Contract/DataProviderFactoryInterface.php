<?php

namespace App\Service\Importer\Contract;

interface DataProviderFactoryInterface
{
    /**
     * Create an instance of the provider based on its id or default provider
     *
     * @param  string|null $providerId
     *
     * @return DataProviderInterface
     */
    public function make(?string $providerId): DataProviderInterface;
}