<?php

declare(strict_types=1);

namespace AssoConnect\PHPPercentBundle\Doctrine\DBAL\Types;

use AssoConnect\PHPPercent\Percent;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Exception\InvalidType;
use Doctrine\DBAL\Types\Type;

class PercentType extends Type
{
    public const TYPE = 'percent';

    public function getName(): string
    {
        return self::TYPE;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        if ($value === null) {
            return $value;
        }

        if ($value instanceof Percent) {
            return $value->toInteger();
        }

        throw $this->createInvalidTypeException($value, ['null', Percent::class]);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Percent
    {
        if ($value === null || $value instanceof Percent) {
            return $value;
        }

        try {
            return new Percent(is_string($value) ? (int)$value : $value);
        } catch (\Throwable $exception) {
            throw $this->createInvalidTypeException($value, ['null', 'integer'], $exception);
        }
    }

    /**
     * @inheritdoc
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    /**
     * DBAL 4 replaced the ConversionException static factories with dedicated exception classes.
     * The runtime conditional below can be inlined once DBAL 3 support is dropped.
     * Excluded from coverage: only one branch can run for a given installed DBAL major.
     *
     * @codeCoverageIgnore
     * @param string[] $possibleTypes
     */
    private function createInvalidTypeException(
        mixed $value,
        array $possibleTypes,
        ?\Throwable $previous = null
    ): ConversionException {
        if (class_exists(InvalidType::class)) {
            return InvalidType::new($value, self::TYPE, $possibleTypes, $previous);
        }

        return ConversionException::conversionFailedInvalidType($value, self::TYPE, $possibleTypes, $previous);
    }
}
