<?php

namespace App\Tests\Feature\Importer;

use App\DataFixtures\CustomerFixture;
use App\Entity\Customer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ImportCustomersCommandTest extends KernelTestCase
{
    /**
     * @var CommandTester
     */
    protected CommandTester $tester;

    /**
     * @var EntityManager|null
     */
    protected ?EntityManager $em;

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

        $application = new Application($kernel);
        $command = $application->find('importer:import-customers');

        $this->tester = new CommandTester($command);
    }

    /**
     * @see KernelTestCase
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        // @see https://symfony.com/doc/current/testing/database.html#functional-testing-of-a-doctrine-repository
        $this->em->close();
        $this->em = null;
    }

    /**
     * @test
     */
    public function shouldSuccessfullyImportCustomers(): void
    {
        $this->tester->execute([]);

        $this->tester->assertCommandIsSuccessful();

        /** @var Customer */
        $customer = $this->em->getRepository(Customer::class)
            ->findOneBy(['email' => 'john@example.org']);

        $this->assertNotNull($customer);
        $this->assertNotNull($customer->getId());
        $this->assertEquals('john@example.org', $customer->getEmail());
        $this->assertEquals('john1234', $customer->getUsername());
        $this->assertEquals('bdc87b9c894da5168059e00ebffb9077', $customer->getPassword());
        $this->assertEquals('John', $customer->getFirstName());
        $this->assertEquals('Doe', $customer->getLastName());
        $this->assertEquals('male', $customer->getGender());
        $this->assertEquals('Australia', $customer->getCountry());
        $this->assertEquals('Hervey Bay', $customer->getCity());
        $this->assertEquals('05-1628-9672', $customer->getPhone());
    }

    /**
     * @test
     */
    public function shouldUpdateCustomerIfAlreadyExistsViaEmail(): void
    {
        $fixture = new CustomerFixture;
        $fixture->load($this->em);

        $this->tester->execute([]);

        $customer = $this->getCustomerRepository()->findOneBy(['email' => 'john@example.org']);

        $this->assertNotNull($customer);
        $this->assertNotNull($customer->getId());
        $this->assertEquals('john@example.org', $customer->getEmail());
        $this->assertEquals('john1234', $customer->getUsername());
        $this->assertEquals('bdc87b9c894da5168059e00ebffb9077', $customer->getPassword());
        $this->assertEquals('John', $customer->getFirstName());
        $this->assertEquals('Doe', $customer->getLastName());
        $this->assertEquals('male', $customer->getGender());
        $this->assertEquals('Australia', $customer->getCountry());
        $this->assertEquals('Hervey Bay', $customer->getCity());
        $this->assertEquals('05-1628-9672', $customer->getPhone());

        // additional check that username johhny does not exists
        $customer = $this->getCustomerRepository()->findOneBy(['username' => 'johnny12']);

        $this->assertNull($customer);
    }

    /**
     * Get the customer repository instance
     *
     * @return EntityRepository
     */
    protected function getCustomerRepository(): EntityRepository
    {
        return $this->em->getRepository(Customer::class);
    }
}
