<?php

namespace App\Entity\ValueObject;

use App\Contract\Domain\ValueObjectInterface;
use DomainException;

class Username implements ValueObjectInterface
{
    /**
     * @var string
     */
    private string $username;

    /**
     * Create username value object instance
     *
     * @param string $username
     */
    public function __construct(string $username)
    {
        if (empty($username)) {
            throw new DomainException('Username should not be empty.');
        }

        if (strlen($username) > 32) {
            throw new DomainException('Username should not exceed more than 32 characters.');
        }

        if (preg_match('/[^\w\d]+/i', $username) === 1) {
            throw new DomainException('Username only accepts alphanumeric characters.');
        }

        $this->username = $username;
    }

    /**
     * @see ValueObjectInterface
     */
    public function getValue(): string
    {
        return $this->username;
    }
}