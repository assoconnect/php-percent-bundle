<?php

declare(strict_types=1);

namespace AssoConnect\PHPPercentBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Sylvain Fabre <sylvain.fabre@assoconnect.com>
 */
class Percent extends Constraint
{
    public int $min = 0;
    public int $max = 10000;
}