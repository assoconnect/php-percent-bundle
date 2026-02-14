<?php

declare(strict_types=1);

namespace AssoConnect\PHPPercentBundle\Tests\Validator\ConstraintsSetProvider\Field;

use AssoConnect\PHPPercent\Percent as PercentObject;
use AssoConnect\PHPPercentBundle\Validator\Constraints\Percent as PercentConstraint;
use AssoConnect\PHPPercentBundle\Validator\ConstraintsSetProvider\Field\PercentProvider;
use AssoConnect\ValidatorBundle\Test\FieldConstraintsSetProviderTestCase;
use AssoConnect\ValidatorBundle\Validator\ConstraintsSetProvider\Field\FieldConstraintsSetProviderInterface;
use Symfony\Component\Validator\Constraints\Type;

class PercentProviderTest extends FieldConstraintsSetProviderTestCase
{
    protected function getFactory(): FieldConstraintsSetProviderInterface
    {
        return new PercentProvider();
    }

    public static function getConstraintsForTypeProvider(): iterable
    {
        yield [
            [
                'type' => 'percent',
                'scale' => null,
            ],
            [
                new Type(PercentObject::class),
                new PercentConstraint(),
            ],
        ];
    }
}
