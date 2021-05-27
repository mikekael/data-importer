<?php

namespace Tests\Unit\Infrastructure\Hasher;

use App\Infrastructure\Hasher\Md5Hasher;
use Tests\TestCase;

class Md5HasherTest extends TestCase
{
    protected Md5Hasher $hasher;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->hasher = new Md5Hasher;
    }

    /**
     * @test
     */
    public function should_return_true(): void
    {
        $hashedValue = md5('password');

        $this->assertTrue(
            $this->hasher->check('password', $hashedValue)
        );
    }

    /**
     * @test
     */
    public function should_return_false(): void
    {
        $hashedValue = md5('password');

        $this->assertFalse(
            $this->hasher->check('password1234', $hashedValue)
        );
    }
}