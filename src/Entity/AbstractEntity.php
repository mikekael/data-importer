<?php

namespace App\Entity;

use App\Contract\Domain\ValueObject\IdentityInterface;

abstract class AbstractEntity
{
    /**
     * Create instance of the abstract entity
     *
     * @param IdentityInterface $id
     */
    protected function __construct(
        private IdentityInterface $id
    ) {}

    /**
     * Retrieve the entity identity
     *
     * @return IdentityInterface
     */
    public function getId(): IdentityInterface
    {
        return $this->id;
    }
}