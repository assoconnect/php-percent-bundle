<?php

declare(strict_types=1);

namespace AssoConnect\PHPPercentBundle\Tests\Doctrine\DBAL\Types;

use AssoConnect\PHPPercent\Percent;
use AssoConnect\PHPPercentBundle\Doctrine\DBAL\Types\PercentType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use stdClass;

class PercentTypeTest extends TestCase
{
    /**
     * @var AbstractPlatform|MockObject
     */
    protected $platform;

    /**
     * @var Type
     */
    protected $type;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $this->platform = $this->getMockForAbstractClass(AbstractPlatform::class);
        $this->type = new PercentType();
    }

    /**
     * @param mixed $value
     *
     * @dataProvider invalidPHPValuesProvider
     */
    public function testInvalidTypeConversionToDatabaseValue($value): void
    {
        $this->expectException(ConversionException::class);

        $this->type->convertToDatabaseValue($value, $this->platform);
    }

    public function testNullConversion(): void
    {
        self::assertNull($this->type->convertToPHPValue(null, $this->platform));
    }

    public function testIntegerConvertsToDatabaseValue(): void
    {
        self::assertIsInt($this->type->convertToDatabaseValue(new Percent(rand()), $this->platform));
    }

    public function testInvalidTypeConversionToPHPValue(): void
    {
        $this->expectException(ConversionException::class);
        $this->type->convertToPHPValue(["an array"], $this->platform);
    }

    public function testConvertIntegerToPHPValue(): void
    {
        $int = rand();
        $percent = new Percent($int);

        self::assertTrue($this->type->convertToPHPValue($int, $this->platform)->equals($percent));
    }

    public function testConvertStringToPHPValue(): void
    {
        $int = rand();
        $string = strval($int);
        $percent = new Percent($int);

        self::assertTrue($this->type->convertToPHPValue($string, $this->platform)->equals($percent));
    }

    /**
     * @return mixed[][]
     */
    public static function invalidPHPValuesProvider(): iterable
    {
        return [
            [0],
            [''],
            ['foo'],
            ['10:11:12'],
            [new stdClass()],
            [27],
            [-1],
            [1.2],
            [[]],
            [['an array']],
        ];
    }
}
