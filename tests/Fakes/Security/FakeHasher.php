<?php

namespace App\Tests\Fakes\Security;

use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class FakeHasher implements PasswordHasherInterface
{
    /**
     * @see PasswordHasherInterface
     */
    public function hash(string $plainPassword): string
    {
        return '5f4dcc3b5aa765d61d8327deb882cf99'; // password (md5)
    }

    /**
     * @see PasswordHasherInterface
     */
    public function verify(string $hashedPassword, string $plainPassword): bool
    {
        return true;
    }

    /**
     * @see PasswordHasherInterface
     */
    public function needsRehash(string $hashedPassword): bool
    {
        return false;
    }
}