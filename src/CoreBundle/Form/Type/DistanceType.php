<?php

namespace Runalyze\Bundle\CoreBundle\Form\Type;

use Runalyze\Metrics\Distance\Unit\AbstractDistanceUnit;

class DistanceType extends AbstractUnitBasedType
{
    /** @var int */
    protected $ViewPrecision = 2;

    /** @var int */
    protected $MaxViewPrecision = 3;

    public function __construct(AbstractDistanceUnit $distanceUnit)
    {
        parent::__construct($distanceUnit);
    }
}
