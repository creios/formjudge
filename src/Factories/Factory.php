<?php

namespace Creios\FormJudge\Factories;

use Creios\FormJudge\Fields\Number;
use Creios\FormJudge\Fields\Text;

class Factory
{

    const BOOLEAN_PATTERN_CONSTRAINT = '^(0|1|TRUE|FALSE|true|false|ON|OFF|on|off)$';
    const INTEGER_PATTERN_CONSTRAINT = '-?[0-9]+';
    const PHP_32BIT_INTEGER_MIN_CONSTRAINT = 0;
    const PHP_32BIT_INTEGER_MAX_CONSTRAINT = 2147483648;

    /**
     * @param bool $requiredConstraint
     * @return Text
     */
    public static function createBooleanText($requiredConstraint = false)
    {
        return Text::createInstance($requiredConstraint)->setPatternConstraint(self::BOOLEAN_PATTERN_CONSTRAINT);
    }

    /**
     * @param bool $requiredConstraint
     * @return \Creios\FormJudge\Fields\Number
     */
    public static function createInteger($requiredConstraint = false)
    {
        return Number::createInstance($requiredConstraint)
            ->setPatternConstraint(self::INTEGER_PATTERN_CONSTRAINT)
            ->setMinConstraint(self::PHP_32BIT_INTEGER_MIN_CONSTRAINT)
            ->setMaxConstraint(self::PHP_32BIT_INTEGER_MAX_CONSTRAINT);
    }

}