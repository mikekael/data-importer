<?php

namespace App\Infrastructure\Types;

use App\Infrastructure\Uuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\GuidType;
use InvalidArgumentException;

class UuidType extends GuidType
{
    /**
     * @var string
     */
    const NAME = 'uuid';

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function getName()
    {
        return static::NAME;
    }

    /**
     * @inheritDoc
     *
     * @param \App\Infrastructure\Uuid $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     *
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value instanceof Uuid) {
            return (string) $value;
        }

        throw ConversionException::conversionFailed($value, static::NAME);
    }

    /**
     * @inheritDoc
     *
     * @param string|null|\App\Infrastructure\Uuid $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     *
     * @return \App\Infrastructure\Uuid
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value instanceof Uuid) {
            return $value;
        }

        try {
            $value = Uuid::fromString($value);
        } catch (InvalidArgumentException $ex) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }

        return $value;
    }
}