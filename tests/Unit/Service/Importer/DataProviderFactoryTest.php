<?php

namespace App\Tests\Unit\Service\Importer;

use App\Service\Importer\DataProvider\RandomUserDataProvider;
use App\Service\Importer\DataProviderFactory;
use PHPUnit\Framework\TestCase;

class DataProviderFactoryTest extends TestCase
{
    /**
     * @var DataProviderFactory
     */
    protected DataProviderFactory $factory;

    /**
     * @see TestCase
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new DataProviderFactory;
    }

    /**
     * @test
     */
    public function shouldReturnInstanceOfRandomUserProvider(): void
    {
        $provider = $this->factory->make();

        $this->assertInstanceOf(RandomUserDataProvider::class, $provider);
    }

    /**
     * @test
     */
    public function shouldReturnInstanceOfRandomUserProviderAsDefault(): void
    {
        $provider = $this->factory->make();

        $this->assertInstanceOf(RandomUserDataProvider::class, $provider);
    }
}
