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
     * @param bool $requiredConstraint
     * @param string $value
     * @param bool $empty
     * @param bool $syntaxError
     * @param string $patternConstraint
     * @param bool $outOfRange
     * @param bool $notEqual
     * @param bool $notPassedLength
     * @param array $optionsConstraint
     * @param bool $notInOptions
     * @param bool $notInPost
     * @param string $minConstraint
     * @param string $maxConstraint
     * @param int $lengthMinConstraint
     * @param int $lengthMaxConstraint
     * @param bool $passed
     */
    public function __construct($requiredConstraint,
                                $value,
                                $empty,
                                $syntaxError,
                                $patternConstraint,
                                $outOfRange,
                                $notEqual,
                                $notPassedLength,
                                array $optionsConstraint,
                                $notInOptions,
                                $notInPost,
                                $minConstraint,
                                $maxConstraint,
                                $lengthMinConstraint,
                                $lengthMaxConstraint,
                                $passed)
    {
        $this->requiredConstraint = $requiredConstraint;
        $this->value = $value;
        $this->empty = $empty;
        $this->patternError = $syntaxError;
        $this->patternConstraint = $patternConstraint;
        $this->outOfRange = $outOfRange;
        $this->notEqual = $notEqual;
        $this->notPassedLength = $notPassedLength;
        $this->optionsConstraint = $optionsConstraint;
        $this->notInOptions = $notInOptions;
        $this->notInPost = $notInPost;
        $this->minConstraint = $minConstraint;
        $this->maxConstraint = $maxConstraint;
        $this->lengthMinConstraint = $lengthMinConstraint;
        $this->lengthMaxConstraint = $lengthMaxConstraint;
        $this->passed = $passed;
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