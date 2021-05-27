<?php

namespace Tests\Unit\Infrastructure\Types;

use App\Infrastructure\Types\UuidType;
use App\Infrastructure\Uuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Mockery;
use Tests\TestCase;

final class UuidTypeTest extends TestCase
{
    /**
     * @var \Doctrine\DBAL\Platforms\AbstractPlatform|\Mockery\MockInterface
     */
    protected $platform;

    /**
     * @var \App\Infrastructure\Types\UuidType
     */
    protected UuidType $type;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type = new UuidType;
        $this->platform = Mockery::mock(AbstractPlatform::class)->makePartial();
    }

    /**
     * List of possible empty values
     *
     * @return array
     */
    public function emptyValue(): array
    {
        return [
            'a null' => [null],
            'an empty string' => ['']
        ];
    }

    /**
     * @test
     *
     * @dataProvider emptyValue
     */
    public function should_return_null_on_empty_db_value($value): void
    {
        $result = $this->type->convertToPHPValue($value, $this->platform);

        $this->assertNull($result);
    }

    /**
     * @test
     */
    public function should_return_if_already_a_uuid_instnace(): void
    {
        $expected = new Uuid;

        $result = $this->type->convertToPHPValue($expected, $this->platform);

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function should_transform_into_uuid_instance(): void
    {
        $value = 'ff6f8cb0-c57d-11e1-9b21-0800200c9a66';

        $result = $this->type->convertToPHPValue($value, $this->platform);

        $this->assertInstanceOf(Uuid::class, $result);
    }

    /**
     * @test
     */
    public function should_throw_exception_on_failed_native_conversion(): void
    {
        $this->expectException(ConversionException::class);

        $this->type->convertToPHPValue('invalid_uuid', $this->platform);
    }

    /**
     * @test
     *
     * @dataProvider emptyValue
     */
    public function should_return_null_on_empty_native_value($value): void
    {
        $result = $this->type->convertToDatabaseValue($value, $this->platform);

        $this->assertNull($result);
    }

    /**
     * @test
     */
    public function should_return_a_string(): void
    {
        $result = $this->type->convertToDatabaseValue($expected = new Uuid, $this->platform);

        $this->assertEquals($expected->getValue(), $result);
    }

    /**
     * @test
     */
    public function should_throw_exception_on_failed_db_conversion(): void
    {
        $this->expectException(ConversionException::class);

        $this->type->convertToDatabaseValue('invalid_value', $this->platform);
    }
}