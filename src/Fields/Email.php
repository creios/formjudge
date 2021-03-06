<?php
namespace Creios\FormJudge\Fields;

/**
 * Class Email
 * @package FormJudge\Fields
 * @see http://w3c.github.io/html-reference/input.email.html
 */
class Email extends Field
{

    /**
     * @var string
     */
    const EMAIL_STRING_PATTERN = '^[A-Za-z0-9]+([-_\.]?[A-Za-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}$';

    /**
     * @param bool $requiredConstraint
     * @return Email
     */
    public static function createInstance($requiredConstraint = false, $optionalField = false)
    {
        return (new self($requiredConstraint, $optionalField))
            ->setType(Field::FIELD_DEFAULT_TYPE)
            ->setPatternConstraint(self::EMAIL_STRING_PATTERN);
    }
}
