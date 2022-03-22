<?php

namespace App\Tests\Entity\ValueObject;

use App\Entity\ValueObject\Username;
use DomainException;
use PHPUnit\Framework\TestCase;

class UsernameTest extends TestCase
{
    /**
     * @test
     */
    public function shouldNotAllowEmptyValue(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Username should not be empty.');

        new Username('');
    }

    /**
     * @test
     */
    public function shouldNotAllowMoreThan32Characters(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Username should not exceed more than 32 characters.');

        new Username(str_repeat('a', 33));
    }

    /**
     * List of possible usernames that contain non alphanumeric characters
     *
     * @return array
     */
    public function usernamesContainingNonAlphanumericCharacters(): array
    {
        return [
            'with space' => ['john doe'],
            'with special characters' => ['john!doe'],
        ];
    }

    /**
     * @test
     *
     * @dataProvider usernamesContainingNonAlphanumericCharacters
     */
    public function shouldNotAllowContainingNonAlphanumericCharacters(string $username): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Username only accepts alphanumeric characters.');

        new Username($username);
    }

    /**
     * List of usernames that are acceptable
     *
     * @return array
     */
    public function usernamesThatAreValid(): array
    {
        return [
            'alphabet' => ['john'],
            'numeric' => ['12345'],
            'alphanumeric' => ['john1234'],
        ];
    }

    /**
     * @test
     *
     * @dataProvider usernamesThatAreValid
     */
    public function shouldSetObjectValue(string $username): void
    {
        $valueObject = new Username($username);

        $this->assertEquals($username, $valueObject->getValue());
    }
}
