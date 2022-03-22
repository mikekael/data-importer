<?php

namespace App\Entity\ValueObject;

class FirstName extends NamePart
{
    /**
     * Create instance of the last name value object
     *
     * @param string $firstName
     */
    public function __construct(string $firstName)
    {
        parent::__construct($firstName, 'First name');
    }
}