<?php

namespace App\Security;

use BadMethodCallException;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class Md5PasswordHasher implements PasswordHasherInterface
{
    /**
     * @see PasswordHasherInterface
     */
    public function hash(string $plainPassword): string
    {
        return md5($plainPassword);
    }

    /**
     * @see PasswordHasherInterface
     */
    public function verify(string $hashedPassword, string $plainPassword): bool
    {
        return $this->hash($plainPassword) === $hashedPassword;
    }

    /**
     * @see PasswordHasherInterface
     */
    public function needsRehash(string $hashedPassword): bool
    {
        return true;
    }
}