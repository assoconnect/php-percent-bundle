<?php

declare(strict_types=1);

namespace AssoConnect\PHPPercentBundle\Doctrine\DBAL\Types;

use AssoConnect\PHPPercent\Percent;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
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

        throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', Percent::class]);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Percent
    {
        if ($value === null || $value instanceof Percent) {
            return $value;
        }

        try {
            return new Percent(is_string($value) ? (int)$value : $value);
        } catch (\Throwable $exception) {
            throw ConversionException::conversionFailedInvalidType(
                $value,
                $this->getName(),
                ['null', 'integer'],
                $exception
            );
        }
    }

    /**
     * @inheritdoc
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
