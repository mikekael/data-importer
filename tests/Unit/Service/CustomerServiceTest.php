<?php

namespace App\Tests\Unit\Service;

use App\Contract\Repository\CustomerRepositoryInterface;
use App\DataTransfer\CustomerViewData;
use App\Entity\Customer;
use App\Service\CustomerService;
use App\Tests\Fakes\Entity\FakeCustomer;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class CustomerServiceTest extends TestCase
{
    /**
     * @var MockInterface
     */
    protected MockInterface $repository;

    /**
     * @var CustomerService
     */
    protected CustomerService $service;

    /**
     * @see TestCase
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @var CustomerRepositoryInterface */
        $this->repository = Mockery::mock(CustomerRepositoryInterface::class);
        $this->service = new CustomerService($this->repository);
    }

    /**
     * @test
     */
    public function shouldReturnCustomerViewModelIfExistsByItsIdentity(): void
    {
        $customer = new FakeCustomer;

        // stub
        $this->repository->shouldReceive('find')
            ->andReturn($customer);

        $result = $this->service->get(1);

        $this->assertNotNull($result);
        $this->assertInstanceOf(CustomerViewData::class, $result);
        $this->assertEquals($customer->getId(), $result->getId());
        $this->assertEquals($customer->getEmail(), $result->getEmail());
        $this->assertEquals($customer->getUsername(), $result->getUsername());
        $this->assertEquals($customer->getFirstName(), $result->getFirstName());
        $this->assertEquals($customer->getLastName(), $result->getLastName());
        $this->assertEquals($customer->getGender(), $result->getGender());
        $this->assertEquals($customer->getGender(), $result->getGender());
        $this->assertEquals($customer->getCountry(), $result->getCountry());
        $this->assertEquals($customer->getCity(), $result->getCity());
        $this->assertEquals($customer->getPhone(), $result->getPhone());
    }

    /**
     * @test
     */
    public function shouldReturnNullIfCustomerDoesNotExistsByItsIdentity(): void
    {
        // stub
        $this->repository->shouldReceive('find')
            ->andReturnNull();

        $result = $this->service->get(1);

        $this->assertNull($result);
    }

    /**
     * @test
     */
    public function shouldYieldCustomerViewModel(): void
    {
        // stub
        $this->repository->shouldReceive('all')
            ->andReturn([
                new FakeCustomer
            ]);

        $result = $this->service->all()->current();

        $this->assertInstanceOf(CustomerViewData::class, $result);
    }

    /**
     * @test
     */
    public function shouldReturnResults(): void
    {
        $this->repository->shouldReceive('all')
            ->andReturn([]);

        $results = $this->service->all();

        $this->assertCount(0, $results);
    }
}
