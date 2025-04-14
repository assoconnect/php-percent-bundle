<?php

declare(strict_types=1);

namespace AssoConnect\PHPPercentBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @author Sylvain Fabre <sylvain.fabre@assoconnect.com>
 */
#[\Attribute]
class Percent extends Constraint
{
    public readonly int $min;
    public readonly int $max;

    public function __construct(int $min = 0, int $max = 10000)
    {
        parent::__construct();

        $this->min = $min;
        $this->max = $max;
    }
}
