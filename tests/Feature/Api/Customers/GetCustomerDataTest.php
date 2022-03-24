<?php

namespace App\Tests\Feature\Api\Customers;

use App\DataFixtures\CustomerFixture;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetCustomerDataTest extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    protected KernelBrowser $client;

    /**
     * @var EntityManager|null
     */
    protected ?EntityManager $em;

    /**
     * @see WebTestCase
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();

        $this->em = self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
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
    public function shouldRespondCustomerData(): void
    {
        $fixture = new CustomerFixture;
        $customer = $fixture->load($this->em);

        $this->client->request('GET', sprintf('/customers/%s', $customer->getId()));

        $this->assertResponseIsSuccessful();
        $this->assertResponseHasHeader('Content-type', 'application/json');

        $content = $this->client->getResponse()->getContent();

        $this->assertJson($content);
        $this->assertEquals([
            'id' => $customer->getId(),
            'full_name' => $customer->getFullName(),
            'email' => $customer->getEmail(),
            'username' => $customer->getUsername(),
            'gender' => $customer->getGender(),
            'country' => $customer->getCountry(),
            'city' => $customer->getCity(),
            'phone' => $customer->getPhone(),
        ], json_decode($content, true));
    }

    /**
     * @test
     */
    public function shouldRespondNotFoundIfCustomerDoesNotExists(): void
    {
        $this->client->request('GET', '/customers/1');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $this->assertResponseHasHeader('Content-type', 'application/json');

        $content = $this->client->getResponse()->getContent();

        $this->assertJson($content);
        $this->assertEquals([
            'message' => 'customer_not_found',
        ], json_decode($content, true));
    }
}
