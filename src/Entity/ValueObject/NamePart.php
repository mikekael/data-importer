<?php

namespace App\Entity\ValueObject;

use App\Contract\Domain\ValueObjectInterface;
use DomainException;

abstract class NamePart implements ValueObjectInterface
{
    /**
     * @var string
     */
    private string $part;

    /**
     * Create instance of the name part value object
     *
     * @param string $part
     * @param string $as
     */
    protected function __construct(string $part, string $as)
    {
        if (empty($part)) {
            throw new DomainException(
                sprintf('%s should not be empty.', $as)
            );
        }

        if (strlen($part) > 64) {
            throw new DomainException(
                sprintf('%s should not exceed more than 64 characters.', $as)
            );
        }

        $this->part = $part;
    }

    /**
     * @see ValueObjectInterface
     */
    public function getValue(): string
    {
        return $this->part;
    }
}