<?php

namespace Tests\Unit\Entities;

use App\Entities\Customer;
use Tests\TestCase;

final class CustomerTest extends TestCase
{
    /**
     * @test
     */
    public function should_return_full_name(): void
    {
        $customer = entity(Customer::class)->make([
            'firstName' => 'John',
            'lastName' => 'Doe'
        ]);

        $this->assertEquals('John Doe', $customer->getFullName());
    }
}