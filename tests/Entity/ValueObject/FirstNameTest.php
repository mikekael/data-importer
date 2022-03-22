<?php

namespace App\Tests\Entity\ValueObject;

use App\Entity\ValueObject\FirstName;
use DomainException;
use PHPUnit\Framework\TestCase;

class FirstNameTest extends TestCase
{
    /**
     * @test
     */
    public function shouldNotAllowEmptyValue(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('First name should not be empty.');

        new FirstName('');
    }

    /**
     * @test
     */
    public function shouldNotAllowMoreThan64Characters(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('First name should not exceed more than 64 characters.');

        new FirstName(str_repeat('a', 65));
    }

    /**
     * @test
     */
    public function shouldSetObjectValue(): void
    {
        $value = new FirstName('John');

        $this->assertEquals('John', $value->getValue());
    }
}
