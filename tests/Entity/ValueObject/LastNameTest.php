<?php

namespace App\Tests\Entity\ValueObject;

use App\Entity\ValueObject\LastName;
use DomainException;
use PHPUnit\Framework\TestCase;

class LastNameTest extends TestCase
{
    /**
     * @test
     */
    public function shouldNotAllowEmptyValue(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Last name should not be empty.');

        new LastName('');
    }

    /**
     * @test
     */
    public function shouldNotAllowMoreThan32Characters(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Last name should not exceed more than 64 characters.');

        new LastName(str_repeat('a', 65));
    }

    /**
     * @test
     */
    public function shouldSetObjectValue(): void
    {
        $value = new LastName('John');

        $this->assertEquals('John', $value->getValue());
    }
}
