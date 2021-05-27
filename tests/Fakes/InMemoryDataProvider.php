<?php

namespace Tests\Fakes;

use App\Services\Importer\Contracts\DataProvider;
use App\DTO\CustomerData;

class InMemoryDataProvider implements DataProvider
{
    /**
     * @inheritDoc
     */
    public function getCustomers(): array
    {
        return [
            new CustomerData([
                'firstName' => 'John',
                'lastName' => 'Doe',
                'username' => 'johndoe1234',
                'email' => 'john@example.org',
                'password' => 'password',
                'gender' => 'male',
                'country' => 'Philippines',
                'city' => 'Makati',
                'phone' => '09221711247',
            ]),
        ];
    }
}