<?php

namespace Tests\Feature\Api\Customers;

use App\Entities\Customer;
use LaravelDoctrine\Migrations\Testing\DatabaseMigrations;
use Tests\TestCase;

final class RetrievedCustomerDataTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function should_return_customer_data(): void
    {
        /** @var \App\Entities\Customer */
        $customer = entity(Customer::class)->create();

        $this->get('/customers/' . $customer->getId()->getValue());

        $this->seeJson([
            'id' => $customer->getId()->getValue(),
            'full_name' => $customer->getFullName(),
            'email' => $customer->getEmail(),
            'username' => $customer->getUsername(),
            'gender' => $customer->getGender(),
            'country' => $customer->getCountry(),
            'city' => $customer->getCity(),
            'phone' => $customer->getPhone(),
        ]);
    }

    /**
     * @test
     */
    public function should_return_error_when_id_format_is_invalid(): void
    {
        $this->get('/customers/1');

        $this->seeStatusCode(400);
        $this->seeJson([
            'message' => 'Customer id is not a valid uuid.',
        ]);
    }

    /**
     * @test
     */
    public function should_return_not_found(): void
    {
        $this->get('/customers/40042432-bed2-11eb-8529-0242ac130003');

        $this->seeStatusCode(404);
        $this->seeJson([
            'message' => 'Customer not found.'
        ]);
    }
}