<?php

declare(strict_types=1);

namespace AssoConnect\PHPPercentBundle\Validator\Constraints;

use AssoConnect\ValidatorBundle\Dto\ValidatorAndConstraint;
use AssoConnect\ValidatorBundle\Validator\Constraints\ComposeValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqualValidator;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqualValidator;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\TypeValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class PercentValidator extends ComposeValidator
{
    protected function getSupportedConstraint(): string
    {
        return Percent::class;
    }

    protected function isEmptyStringAccepted(): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    protected function sanitizeValue(mixed $value): mixed
    {
        if ($value instanceof \AssoConnect\PHPPercent\Percent) {
            return $value->toInteger();
        }
        return $value;
    }

    protected function getValidatorsAndConstraints(mixed $value, Constraint $constraint): array
    {
        if (!$constraint instanceof Percent) {
            throw new UnexpectedTypeException($constraint, Percent::class);
        }

        if (is_float($value) || is_integer($value)) {
            return [
                new ValidatorAndConstraint(new GreaterThanOrEqualValidator(), new GreaterThanOrEqual($constraint->min)),
                new ValidatorAndConstraint(new LessThanOrEqualValidator(), new LessThanOrEqual($constraint->max)),
            ];
        }

        return [new ValidatorAndConstraint(new TypeValidator(), new Type('float'))];
    }
}
