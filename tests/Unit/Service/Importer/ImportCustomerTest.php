<?php

namespace App\Tests\Unit\Service\Importer;

use App\Contract\Repository\CustomerRepositoryInterface;
use App\Entity\Customer;
use App\Service\Importer\ImportCustomerService;
use App\Tests\Fakes\Entity\FakeCustomer;
use App\Tests\Fakes\Service\Importer\FakeDataProviderFactory;
use App\Tests\Fakes\Security\FakeHasher;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class ImportCustomerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var ImportCustomerService
     */
    protected ImportCustomerService $service;

    /**
     * @var MockInterface | \App\Contract\Repository\CustomerRepositoryInterface
     */
    protected MockInterface $repository;

    /**
     * @see TestCase
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @var MockInterface | \App\Contract\Repository\CustomerRepositoryInterface */
        $this->repository = Mockery::mock(CustomerRepositoryInterface::class)
            ->shouldIgnoreMissing();

        $this->service = new ImportCustomerService(
            new FakeDataProviderFactory,
            $this->repository,
            new FakeHasher
        );
    }

    /**
     * @test
     */
    public function shouldCreateCustomerWhenUserDoesNotExistsViaEmail(): void
    {
        // stub
        $this->repository->shouldReceive('findByEmailAddress')
            ->with('john@example.org')
            ->andReturnNull();

        $this->service->run();

        $this->repository->shouldHaveReceived('save')
            ->with(Mockery::on(function (Customer $arg) {
                return $arg->getEmail() === 'john@example.org'
                    && $arg->getUsername() === 'john1234'
                    && $arg->getPassword() === '5f4dcc3b5aa765d61d8327deb882cf99'
                    && $arg->getFirstName() === 'John'
                    && $arg->getLastName() === 'Doe'
                    && $arg->getGender() === 'male'
                    && $arg->getCountry() === 'Australia'
                    && $arg->getCity() === 'Hervey Bay'
                    && $arg->getPhone() === '05-1628-9672';
            }))
            ->once();
    }

    /**
     * @test
     */
    public function shouldUpdateCustomerWhenUserExistsViaEmail(): void
    {
        // stub
        $this->repository->shouldReceive('findByEmailAddress')
            ->with('john@example.org')
            ->andReturn(new FakeCustomer);

        $this->service->run();

        $this->repository->shouldHaveReceived('save')
            ->with(Mockery::on(function (Customer $arg) {
                return $arg->getId() === 1
                    && $arg->getEmail() === 'john@example.org'
                    && $arg->getUsername() === 'john1234'
                    && $arg->getUsername() !== 'johnny12'
                    && $arg->getPassword() === '5f4dcc3b5aa765d61d8327deb882cf99'
                    && $arg->getPassword() !== 'bdc87b9c894da5168059e00ebffb9077'
                    && $arg->getFirstName() === 'John'
                    && $arg->getLastName() !== 'Johnny'
                    && $arg->getLastName() === 'Doe'
                    && $arg->getGender() === 'male'
                    && $arg->getCountry() === 'Australia'
                    && $arg->getCity() === 'Hervey Bay'
                    && $arg->getCity() !== 'Mackay'
                    && $arg->getPhone() === '05-1628-9672'
                    && $arg->getPhone() !== '04-3987-1147';
            }))
            ->once();
    }
}
