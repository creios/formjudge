<?php

namespace Creios\FormJudge\Judgement;

use Creios\FormJudge\Fields\FieldTrait;

/**
 * Class FieldJudgement
 * @package Creios\FormJudge\Judgement
 */
class FieldJudgement
{

    use FieldTrait;
    use FieldJudgementTrait;

    /**
     * FieldJudgement constructor.
     * @param bool $mandatoryConstraint
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
    public function __construct($mandatoryConstraint,
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
        $this->mandatoryConstraint = $mandatoryConstraint;
        $this->value = $value;
        $this->empty = $empty;
        $this->syntaxError = $syntaxError;
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
     * @return boolean
     */
    public function hasMandatoryConstraint()
    {
        return $this->mandatoryConstraint;
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
        return $this->syntaxError;
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
     * @return array
     */
    public function getOptionsConstraint()
    {
        return $this->optionsConstraint;
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
     * @return string
     */
    public function getMinConstraint()
    {
        return $this->minConstraint;
    }

    /**
     * @return string
     */
    public function getMaxConstraint()
    {
        return $this->maxConstraint;
    }

    /**
     * @return int
     */
    public function getLengthMinConstraint()
    {
        return $this->lengthMinConstraint;
    }

    /**
     * @return int
     */
    public function getLengthMaxConstraint()
    {
        return $this->lengthMaxConstraint;
    }

    /**
     * @return string
     */
    public function getPatternConstraint()
    {
        return $this->patternConstraint;
    }

    /**
     * @return boolean
     */
    public function hasPassed()
    {
        return $this->passed;
    }

}