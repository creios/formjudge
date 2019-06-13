<?php

namespace Creios\FormJudge\Fields;

/**
 * Class Week
 * @package Creios\FormJudge\Fields
 * @see http://w3c.github.io/html-reference/input.week.html
 */
class Week extends Field
{

    /**
     * @var string
     */
    const WEEK_STRING_PATTERN = '^\d\d\d\d-W((0[1-9])|([1-4][0-9])|(5[0-3]))$';

    /**
     * @param bool $requiredConstraint
     * @return Week
     */
    public static function createInstance($requiredConstraint = false, $optionalField = false)
    {
        return (new self($requiredConstraint, $optionalField))
            ->setType(Field::FIELD_DEFAULT_TYPE)
            ->setPatternConstraint(self::WEEK_STRING_PATTERN);
    }
}