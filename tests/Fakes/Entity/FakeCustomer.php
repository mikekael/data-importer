<?php

namespace App\Tests\Fakes\Entity;

use App\DataTransfer\CustomerData;
use App\Entity\Customer;

class FakeCustomer extends Customer
{
    /**
     * Create instance of the fake customer
     */
    public function __construct()
    {
        $this->fill(new CustomerData(
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
    }

    /**
     * @see Customer
     */
    public function getId(): ?int
    {
        return 1;
    }
}