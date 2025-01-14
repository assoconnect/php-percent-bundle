<?php

declare(strict_types=1);

namespace AssoConnect\PHPPercentBundle\Tests\Validator\Constraints;

use AssoConnect\PHPPercentBundle\Validator\Constraints\Percent;
use AssoConnect\PHPPercentBundle\Validator\Constraints\PercentValidator;
use AssoConnect\ValidatorBundle\Test\ConstraintValidatorTestCase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @extends ConstraintValidatorTestCase<PercentValidator>
 */
class PercentValidatorTest extends ConstraintValidatorTestCase
{
    protected function getConstraint(): Constraint
    {
        return new Percent(10, 50);
    }

    public function createValidator(): ConstraintValidator
    {
        return new PercentValidator();
    }

    public function providerValidValues(): iterable
    {
        yield [null];
        yield [10.0];
        yield [10];
        yield [25.0];
        yield [50.0];
        yield [50];
        yield [new \AssoConnect\PHPPercent\Percent(20)];
    }

    public function providerInvalidValues(): iterable
    {
        yield [
            'a',
            Type::INVALID_TYPE_ERROR,
            'This value should be of type {{ type }}.',
            [
                '{{ type }}' => 'float',
                '{{ value }}' => '"a"',
            ],
        ];

        yield [
            '',
            NotBlank::IS_BLANK_ERROR,
            'This value should not be blank.',
        ];

        yield [
            5,
            GreaterThanOrEqual::TOO_LOW_ERROR,
            'This value should be greater than or equal to {{ compared_value }}.',
            [
                '{{ value }}' => '5',
                '{{ compared_value_type }}' => 'int',
                '{{ compared_value }}' => '10',
            ],
        ];

        yield [
            60,
            LessThanOrEqual::TOO_HIGH_ERROR,
            'This value should be less than or equal to {{ compared_value }}.',
            [
                '{{ value }}' => '60',
                '{{ compared_value_type }}' => 'int',
                '{{ compared_value }}' => '50',
            ],
        ];
    }
}
