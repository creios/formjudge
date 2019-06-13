<?php

namespace Creios\FormJudge\Fields;

/**
 * Class DateTimeLocal
 * @package Creios\FormJudge\Fields
 * @see http://w3c.github.io/html-reference/input.datetime-local.html
 */
class DateTimeLocal extends Field
{

    /**
     * @var string
     */
    const DATETIMELOCAL_STRING_PATTERN = '^[0-9]{4}-(((0[13578]|(10|12))-(0[1-9]|[1-2][0-9]|3[0-1]))|(02-(0[1-9]|[1-2][0-9]))|((0[469]|11)-(0[1-9]|[1-2][0-9]|30)))T([01]?\d|2[0-3]):([0-5]?\d):([0-5]?\d)$';

    /**
     * @param bool $requiredConstraint
     * @return DateTimeLocal
     */
    public static function createInstance($requiredConstraint = false, $optionalField = false)
    {
        return (new self($requiredConstraint, $optionalField))
            ->setType(Field::FIELD_DEFAULT_TYPE)
            ->setPatternConstraint(self::DATETIMELOCAL_STRING_PATTERN);
    }
}