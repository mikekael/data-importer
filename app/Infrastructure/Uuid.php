<?php

namespace App\Infrastructure;

use Illuminate\Support\Str;
use App\Contracts\Domain\UniqueId as UniqueIdInterface;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Stringable;

class Uuid implements UniqueIdInterface, Stringable
{
    /**
     * @var string
     */
    protected string $value;

    /**
     * Create instance of unique identity
     */
    public function __construct()
    {
        $this->value = Str::uuid()->toString();
    }

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return $this->getValue();
    }

    /**
     * Create a unique id instance from string
     *
     * @param  string $id
     *
     * @return \App\Infrastructure\Uuid
     */
    public static function fromString(string $id): Uuid
    {
        return tap(new static, fn($instance) => $instance->value = RamseyUuid::fromString($id)->toString());
    }
}