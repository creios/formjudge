<?php

namespace Creios\FormJudge\Fields;

/**
 * Class Date
 * @package FormJudge\Fields
 * @see http://w3c.github.io/html-reference/input.date.html
 */
class Date extends Field
{

    /**
     * @var string
     */
    const DATE_STRING_PATTERN = '^[0-9]{4}-(((0[13578]|(10|12))-(0[1-9]|[1-2][0-9]|3[0-1]))|(02-(0[1-9]|[1-2][0-9]))|((0[469]|11)-(0[1-9]|[1-2][0-9]|30)))$';

    /**
     * @param bool $requiredConstraint
     * @return Date
     * @throws \InvalidArgumentException
     */
    public static function createInstance($requiredConstraint = false)
    {
        return (new self($requiredConstraint))
            ->setType(Field::FIELD_DEFAULT_TYPE)
            ->setPatternConstraint(self::DATE_STRING_PATTERN);
    }

}
