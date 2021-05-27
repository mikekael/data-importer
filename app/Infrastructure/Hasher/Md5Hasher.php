<?php

namespace App\Infrastructure\Hasher;

use BadMethodCallException;
use Illuminate\Contracts\Hashing\Hasher;

final class Md5Hasher implements Hasher
{
    /**
     * @inheritDoc
     *
     * @throws BadMethodCallException
     */
    public function info($hashedValue)
    {
        throw new BadMethodCallException('not implemented');
    }

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function make($value, array $options = [])
    {
        return md5($value);
    }

    /**
     * @inheritDoc
     *
     * @return boolean
     */
    public function check($value, $hashedValue, array $options = [])
    {
        return $this->make($value) === $hashedValue;
    }

    /**
     * @inheritDoc
     *
     * @throws BadMethodCallException
     */
    public function needsRehash($hashedValue, array $options = [])
    {
        throw new BadMethodCallException('not implemented');
    }
}