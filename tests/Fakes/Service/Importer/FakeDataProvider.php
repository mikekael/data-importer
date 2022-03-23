<?php

namespace App\Tests\Fakes\Service\Importer;

use App\Service\Importer\Contract\DataProviderInterface;
use App\Service\Importer\CustomerData;

class FakeDataProvider implements DataProviderInterface
{
    /**
     * @see DataProviderInterface
     */
    public function getCustomers(): iterable
    {
        return [
            new CustomerData(
                'john@example.org',
                'john1234',
                'password1234',
                'John',
                'Doe',
                'male',
                'Australia',
                'Hervey Bay',
                '05-1628-9672',
            )
        ];
    }
}