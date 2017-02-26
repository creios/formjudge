<?php

namespace Creios\FormJudge\Fields;

/**
 * Class Color
 * @package Creios\FormJudge\Fields
 * @see http://w3c.github.io/html-reference/input.color.html
 */
class Color extends Field
{

    /**
     * @var string
     */
    const SIMPLE_COLOR_STRING_PATTERN = '^#[0-9abcdefABCDEF]{1,6}$';

    /**
     * @param bool $requiredConstraint
     * @return Color
     * @throws \InvalidArgumentException
     */
    public static function createInstance($requiredConstraint = false)
    {
        return (new self($requiredConstraint))
            ->setType(Field::FIELD_DEFAULT_TYPE)
            ->setPatternConstraint(self::SIMPLE_COLOR_STRING_PATTERN);
    }

}