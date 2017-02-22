<?php

namespace Creios\FormJudge\Factories;

use Creios\FormJudge\Fields\Text;

class Factory
{
    const BOOLEAN_PATTERN_CONSTRAINT = '^(0|1|TRUE|FALSE|true|false|ON|OFF|on|off)$';

    /**
     * @param bool $requiredConstraint
     * @return Text
     */
    public static function createBooleanText($requiredConstraint = false)
    {
        return (new Text($requiredConstraint))->setPatternConstraint(self::BOOLEAN_PATTERN_CONSTRAINT);
    }

}