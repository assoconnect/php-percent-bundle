<?php

declare(strict_types=1);

namespace AssoConnect\PHPPercentBundle\Validator\ConstraintsSetProvider\Field;

use AssoConnect\PHPPercent\Percent as PercentObject;
use AssoConnect\PHPPercentBundle\Validator\Constraints\Percent as PercentConstraint;
use AssoConnect\ValidatorBundle\Validator\ConstraintsSetProvider\Field\FieldConstraintsSetProviderInterface;
use Symfony\Component\Validator\Constraints\Type;

class PercentProvider implements FieldConstraintsSetProviderInterface
{
    public function supports(string $type): bool
    {
        return 'percent' === $type;
    }

    public function getConstraints(array $fieldMapping): array
    {
        return [
            new Type(PercentObject::class),
            new PercentConstraint(),
        ];
    }
}
