<?php

namespace Tests\Fakes;

use App\Contracts\Domain\UniqueId;

class FakeUniqueId implements UniqueId
{
    /**
     * @inheritDoc
     */
    public function getValue(): string
    {
        return 'a2330d4a-d959-44eb-852f-6d41fe7b045b';
    }
}