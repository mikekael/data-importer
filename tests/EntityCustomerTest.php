<?php

namespace App\Tests;

use App\DataTransfer\CustomerData;
use App\Entity\Customer;
use PHPUnit\Framework\TestCase;

class EntityCustomerTest extends TestCase
{
    /**
     * @test
     */
    public function fullNameShouldDerivedFromConcatenatedFirstNameAndLastName(): void
    {
        $customer = new Customer(new CustomerData(
            'john@example.org',
            'johnny12',
            'bdc87b9c894da5168059e00ebffb9077',
            'Johnny',
            'Doe',
            'male',
            'Australia',
            'Mackay',
            '04-3987-1147',
        ));

        $name = $customer->getFullName();

        $this->assertEquals('Johnny Doe', $name);
    }
}
