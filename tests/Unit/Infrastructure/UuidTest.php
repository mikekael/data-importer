<?php

namespace Tests\Unit\Infrastructure;

use App\Infrastructure\Uuid;
use Tests\TestCase;
use Illuminate\Support\Str;

final class UuidTest extends TestCase
{
    /**
     * @test
     */
    public function should_generate_new_uuid(): void
    {
        $id = new Uuid;

        $this->assertTrue(Str::isUuid($id->getValue()));
    }

    /**
     * @test
     */
    public function should_create_instance_from_existing_uuid(): void
    {
        $id = Uuid::fromString($existing = Str::uuid());

        $this->assertInstanceOf(Uuid::class, $id);
        $this->assertEquals($existing, $id->getValue());
    }
}