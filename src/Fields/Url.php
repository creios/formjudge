<?php
namespace Creios\FormJudge\Fields;

/**
 * Class Url
 * @package FormJudge\Fields
 * @see http://w3c.github.io/html-reference/input.url.html
 */
class Url extends Field
{

    /**
     * @var string
     */
    const SIMPLE_URL_STRING_PATTERN = '^[A-Za-z0-9-]+(\\.[A-Za-z0-9-]+)*(\\.[A-Za-z]{2,})$';

    /**
     * @param bool $requiredConstraint
     * @return Url
     */
    public static function createInstance($requiredConstraint = false)
    {
        return (new self($requiredConstraint))->setPatternConstraint(self::SIMPLE_URL_STRING_PATTERN);
    }

}
