<?php

namespace Creios\FormJudge\Fields;

/**
 * Class Number
 * @package Creios\FormJudge\Fields
 * @see http://w3c.github.io/html-reference/input.number.html
 */
class Number extends Field
{

    /**
     * @var string
     */
    const NUMBER_TYPE = 'float';

    /**
     * @param bool $requiredConstraint
     * @return static
     */
    public static function createInstance($requiredConstraint = false)
    {
        return (new static($requiredConstraint))
            ->setType(self::NUMBER_TYPE);
    }
}