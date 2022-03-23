<?php

namespace App\Tests\Fakes\Service\Importer;

use App\Service\Importer\Contract\DataProviderFactoryInterface;
use App\Service\Importer\Contract\DataProviderInterface;

final class FakeDataProviderFactory implements DataProviderFactoryInterface
{
    /**
     * @see DataProviderFactoryInterface
     */
    public function make(?string $providerId): DataProviderInterface
    {
        return new FakeDataProvider;
    }
}