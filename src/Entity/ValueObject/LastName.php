<?php

namespace App\Entity\ValueObject;

class LastName extends NamePart
{
    /**
     * Create instance of the last name value object
     *
     * @param string $lastName
     */
    public function __construct(string $lastName)
    {
        parent::__construct($lastName, 'Last name');
    }
}