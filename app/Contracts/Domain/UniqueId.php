<?php

namespace App\Contracts\Domain;

interface UniqueId
{
    /**
     * Retrieved unique identity value
     *
     * @return mixed
     */
    public function getValue();
}