<?php

namespace Tests\Unit\Services\Importer;

use Mockery;
use Tests\TestCase;
use App\Contracts\Domain\CustomerRepository;
use App\DTO\CustomerData;
use App\Entities\Customer;
use App\Services\Importer\ImportCustomerService;
use Doctrine\ORM\EntityManagerInterface;
use Mockery\MockInterface;
use Tests\Fakes\FakeUniqueId;
use Tests\Fakes\InMemoryDataProvider;

final class ImportCustomerServiceTest extends TestCase
{
    /**
     * @test
     */
    public function should_be_able_to_create_new_customer(): void
    {
        $repository = $this->makeCustomerRepository();
        $em = $this->makeEntityManager();

        $repository->shouldReceive('getNextIdentity')->once()->andReturn(new FakeUniqueId);

        (new ImportCustomerService(new InMemoryDataProvider, $repository, $em))->run();
    }

    /**
     * @test
     */
    public function should_update_customer_record_if_exists_via_email(): void
    {
        /** @var \App\Entities\Customer|\Mockery\MockInterface */
        $existingCustomer = Mockery::spy(Customer::class);
        $repository = tap($this->makeCustomerRepository(), function (MockInterface $mock) use ($existingCustomer) {
            $mock->shouldReceive('findByEmail')->andReturn($existingCustomer);
        });
        $em = $this->makeEntityManager();

        // act
        (new ImportCustomerService(new InMemoryDataProvider, $repository, $em))->run();

        // assert
        $existingCustomer->shouldHaveReceived('update')
            ->with(Mockery::type(CustomerData::class))
            ->once();
    }

    /**
     * Create a mocked instance of customer repository
     *
     * @return \App\Contracts\Domain\CustomerRepository|\Mockery\MockInterface
     */
    protected function makeCustomerRepository()
    {
        return tap(Mockery::mock(CustomerRepository::class), function (MockInterface $mock) {
            $mock->shouldIgnoreMissing();
        });
    }

    /**
     * Create a mock instance of entity manager
     *
     * @return \Doctrine\ORM\EntityManagerInterface|\Mockery\MockInterface
     */
    protected function makeEntityManager()
    {
        return tap(Mockery::mock(EntityManagerInterface::class), function (MockInterface $mock) {
            $mock->shouldIgnoreMissing();
        });
    }
}
