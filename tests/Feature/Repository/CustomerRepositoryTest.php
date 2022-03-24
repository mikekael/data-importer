<?php

namespace App\Tests\Feature\Repository;

use App\DataFixtures\CustomerFixture;
use App\DataTransfer\CustomerData;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CustomerRepositoryTest extends KernelTestCase
{
    /**
     * @var EntityManager|null
     */
    protected ?EntityManager $em;

    /**
     * @var CustomerRepository
     */
    protected CustomerRepository $repository;

    /**
     * @see KernelTestCase
     */
    protected function setUp(): void
    {
        parent::setUp();

        $kernel = self::bootKernel();

        $this->em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->repository = new CustomerRepository($this->em);
    }

    /**
     * @test
     */
    public function shouldReturnCustomerBasedOnItsIdentity(): void
    {
        $fixture = new CustomerFixture;
        $customer = $fixture->load($this->em);

        $result = $this->repository->find($customer->getId());

        $this->assertNotNull($result);
        $this->assertEquals($customer->getId(), $result->getId());
    }

    /**
     * @test
     */
    public function shouldReturnNullIfCustomerDoesNotExistsByItsIdentity(): void
    {
        $result = $this->repository->find(1);

        $this->assertNull($result);
    }

    /**
     * @test
     */
    public function shouldReturnCustomerBasedOnItsEmailAddress(): void
    {
        $fixture = new CustomerFixture;
        $customer = $fixture->load($this->em);

        $result = $this->repository->findByEmailAddress('john@example.org');

        $this->assertNotNull($result);
        $this->assertEquals($customer->getId(), $result->getId());
        $this->assertEquals('john@example.org', $result->getEmail());
    }

    /**
     * @test
     */
    public function shouldReturnNullIfCustomerDoesNotExistsByItsEmailAddress(): void
    {
        $result = $this->repository->findByEmailAddress('johnny@example.org');

        $this->assertNull($result);
    }

    /**
     * @test
     */
    public function shouldPersistsCustomerToStorage(): void
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

        $result = $this->repository->save($customer);

        $this->assertNotNull($result);
        $this->assertNotNull($result->getId());
        $this->assertEquals($customer->getEmail(), $result->getEmail());
    }

    /**
     * @test
     */
    public function shouldRetrievedListOfCustomers(): void
    {
        $fixture = new CustomerFixture;
        $customer = $fixture->load($this->em);

        $results = $this->repository->all();

        $this->assertCount(1, $results);

        /** @var Customer */
        list ($data) = $results;

        $this->assertInstanceOf(Customer::class, $data);
        $this->assertEquals($customer->getId(), $data->getId());
    }
}
