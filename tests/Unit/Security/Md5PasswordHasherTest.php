<?php

namespace App\Tests\Unit\Security;

use App\Security\Md5PasswordHasher;
use PHPUnit\Framework\TestCase;

class Md5PasswordHasherTest extends TestCase
{
    /**
     * @type Md5PasswordHasher
     */
    protected Md5PasswordHasher $hasher;

    /**
     * @see TestCase
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->hasher = new Md5PasswordHasher;
    }

    /**
     * @test
     */
    public function shouldHashPasswordToMd5(): void
    {
        $hashed = $this->hasher->hash('password');

        $this->assertEquals('5f4dcc3b5aa765d61d8327deb882cf99', $hashed);
    }

    /**
     * @test
     */
    public function shouldReturnTrueWhenHashMatchesThePlainPassword(): void
    {
        $result = $this->hasher->verify('5f4dcc3b5aa765d61d8327deb882cf99', 'password');

        $this->assertTrue($result);
    }
}
