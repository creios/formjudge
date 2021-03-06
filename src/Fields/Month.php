<?php

namespace Creios\FormJudge\Fields;

/**
 * Class Month
 * @package Creios\FormJudge\Fields
 * @see http://w3c.github.io/html-reference/input.month.html
 */
class Month extends Field
{

    /**
     * @var string
     */
    const MONTH_STRING_PATTERN = '^\d\d\d\d-((0[1-9])|(1[0-2]))$';

    /**
     * @param bool $requiredConstraint
     * @return Month
     */
    public static function createInstance($requiredConstraint = false, $optionalField = false)
    {
        return (new self($requiredConstraint, $optionalField))
            ->setType(Field::FIELD_DEFAULT_TYPE)
            ->setPatternConstraint(self::MONTH_STRING_PATTERN);
    }
}