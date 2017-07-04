<?php

namespace Creios\FormJudge\Fields;

/**
 * Class Range
 * @package Creios\FormJudge\Fields
 * @see http://w3c.github.io/html-reference/input.range.html
 */
class Range extends Field
{

    /**
     * @var string
     */
    const RANGE_TYPE = 'float';

    /**
     * @param bool $requiredConstraint
     * @return static
     */
    public static function createInstance($requiredConstraint = false)
    {
        return (new static($requiredConstraint))->setType(self::RANGE_TYPE);
    }

}