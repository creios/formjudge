<?php

namespace Creios\FormJudge\Factories;

use Creios\FormJudge\Fields\Number;
use Creios\FormJudge\Fields\Text;

class Factory
{

    const BOOLEAN_PATTERN_CONSTRAINT = '^(0|1|TRUE|FALSE|true|false|ON|OFF|on|off)$';
    const INT_PATTERN_CONSTRAINT = '-?[0-9]+';
    const PHP_32BIT_INT_MIN_CONSTRAINT = 0;
    const PHP_32BIT_INT_MAX_CONSTRAINT = 2147483648;
    const INT_TYPE = 'int';

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
    public static function createInt($requiredConstraint = false)
    {
        return Number::createInstance($requiredConstraint)
            ->setType(self::INT_TYPE)
            ->setPatternConstraint(self::INT_PATTERN_CONSTRAINT)
            ->setMinConstraint(self::PHP_32BIT_INT_MIN_CONSTRAINT)
            ->setMaxConstraint(self::PHP_32BIT_INT_MAX_CONSTRAINT);
    }

}