<?php
namespace Creios\FormJudge\Fields;

/**
 * Class Time
 * @package FormJudge\Fields
 * @see http://w3c.github.io/html-reference/input.time.html
 */
class Time extends Field
{

    /**
     * @var string
     */
    const TIME_STRING_PATTERN = '^([01]?\d|2[0-3])(:([0-5]?\d))+$';

    /**
     * @param bool $requiredConstraint
     * @return Time
     */
    public static function createInstance($requiredConstraint = false)
    {
        return (new self($requiredConstraint))->setPatternConstraint(self::TIME_STRING_PATTERN);
    }

}
