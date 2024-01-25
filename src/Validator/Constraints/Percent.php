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
    public readonly int $min;
    public readonly int $max;

    public function __construct()
    {
        parent::__construct();

        $this->min = 0;
        $this->max = 10000;
    }
}
