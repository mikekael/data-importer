<?php

namespace App\Contract\Domain;

interface ValueObjectInterface
{
    /**
     * Retrieved the value object domain value
     *
     * @return mixed
     */
    public function getValue(): mixed;
}