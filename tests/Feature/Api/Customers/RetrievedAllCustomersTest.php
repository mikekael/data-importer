<?php

namespace Tests\Feature\Api\Customers;

use App\Entities\Customer;
use LaravelDoctrine\Migrations\Testing\DatabaseMigrations;
use Tests\TestCase;

final class RetrievedAllCustomersTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function should_retrieved_all_customers(): void
    {
        /** @var \App\Entities\Customer */
        $customer = entity(Customer::class)->create();

        $this->get('/customers');

        $this->seeJson([
            'data' => [[
                'id' => $customer->getId()->getValue(),
                'full_name' => $customer->getFullName(),
                'email' => $customer->getEmail(),
                'country' => $customer->getCountry(),
            ]]
        ]);
    }

    /**
     * @test
     */
    public function should_display_items_per_page(): void
    {
        /** @var \App\Entities\Customer */
        entity(Customer::class)->times(2)->create()->first();

        $this->get('/customers?per_page=1');

        $body = json_decode($this->response->getContent(), true);

        $this->assertCount(1, $body['data']);
    }
}