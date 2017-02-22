<?php

namespace Creios\FormJudge\Court;

use Creios\FormJudge\Traits\FieldGetterTrait;
use Creios\FormJudge\Traits\FieldJudgementTrait;
use Creios\FormJudge\Traits\FieldTrait;

/**
 * Class FieldJudgement
 * @package Creios\FormJudge\Court
 */
class FieldJudgement
{

    use FieldTrait;
    use FieldGetterTrait;
    use FieldJudgementTrait;

    /**
     * FieldJudgement constructor.
     * @param bool $empty
     * @param int $lengthMaxConstraint
     * @param int $lengthMinConstraint
     * @param string $maxConstraint
     * @param string $minConstraint
     * @param bool $notEqual
     * @param bool $notInOptions
     * @param bool $notInPost
     * @param bool $notPassedLength
     * @param array $optionsConstraint
     * @param bool $outOfRange
     * @param bool $passed
     * @param string $patternConstraint
     * @param bool $requiredConstraint
     * @param bool $syntaxError
     * @param bool $typeError
     * @param string $value
     */
    public function __construct(
        $empty,
        $lengthMaxConstraint,
        $lengthMinConstraint,
        $maxConstraint,
        $minConstraint,
        $notEqual,
        $notInOptions,
        $notInPost,
        $notPassedLength,
        $optionsConstraint,
        $outOfRange,
        $passed,
        $patternConstraint,
        $requiredConstraint,
        $syntaxError,
        $typeError,
        $value
    )
    {
        $this->empty = $empty;
        $this->lengthMaxConstraint = $lengthMaxConstraint;
        $this->lengthMinConstraint = $lengthMinConstraint;
        $this->maxConstraint = $maxConstraint;
        $this->minConstraint = $minConstraint;
        $this->notEqual = $notEqual;
        $this->notInOptions = $notInOptions;
        $this->notInPost = $notInPost;
        $this->notPassedLength = $notPassedLength;
        $this->optionsConstraint = $optionsConstraint;
        $this->outOfRange = $outOfRange;
        $this->passed = $passed;
        $this->patternConstraint = $patternConstraint;
        $this->patternError = $syntaxError;
        $this->requiredConstraint = $requiredConstraint;
        $this->typeError = $typeError;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return boolean
     */
    public function isEmpty()
    {
        return $this->empty;
    }

    /**
     * @return boolean
     */
    public function isSyntaxError()
    {
        return $this->patternError;
    }

    /**
     * @return boolean
     */
    public function isOutOfRange()
    {
        return $this->outOfRange;
    }

    /**
     * @return boolean
     */
    public function isNotEqual()
    {
        return $this->notEqual;
    }

    /**
     * @return boolean
     */
    public function isNotPassedLength()
    {
        return $this->notPassedLength;
    }

    /**
     * @return boolean
     */
    public function isNotInOptions()
    {
        return $this->notInOptions;
    }

    /**
     * @return boolean
     */
    public function isNotInPost()
    {
        return $this->notInPost;
    }

    /**
     * @return boolean
     */
    public function hasPassed()
    {
        return $this->passed;
    }

    /**
     * @return bool
     */
    public function isPatternError()
    {
        return $this->patternError;
    }

    /**
     * @return bool
     */
    public function isTypeError()
    {
        return $this->typeError;
    }

}