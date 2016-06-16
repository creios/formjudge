<?php

namespace Creios\FormJudge\Judgement;

/**
 * Class FieldJudgement
 * @package Creios\FormJudge\Judgement
 */
class FieldJudgement
{

    use FieldJudgementTrait;

    /**
     * FieldJudgement constructor.
     * @param bool $mandatory
     * @param string $value
     * @param bool $empty
     * @param bool $syntaxError
     * @param string $pattern
     * @param bool $outOfRange
     * @param bool $notEqual
     * @param bool $notPassedLength
     * @param array $options
     * @param bool $notInOptions
     * @param bool $notInPost
     * @param string $min
     * @param string $max
     * @param int $lengthMin
     * @param int $lengthMax
     * @param bool $passed
     */
    public function __construct($mandatory,
                                $value,
                                $empty,
                                $syntaxError,
                                $pattern,
                                $outOfRange,
                                $notEqual,
                                $notPassedLength,
                                array $options,
                                $notInOptions,
                                $notInPost,
                                $min,
                                $max,
                                $lengthMin,
                                $lengthMax,
                                $passed)
    {
        $this->mandatory = $mandatory;
        $this->value = $value;
        $this->empty = $empty;
        $this->syntaxError = $syntaxError;
        $this->pattern = $pattern;
        $this->outOfRange = $outOfRange;
        $this->notEqual = $notEqual;
        $this->notPassedLength = $notPassedLength;
        $this->options = $options;
        $this->notInOptions = $notInOptions;
        $this->notInPost = $notInPost;
        $this->min = $min;
        $this->max = $max;
        $this->lengthMin = $lengthMin;
        $this->lengthMax = $lengthMax;
        $this->passed = $passed;
    }

    /**
     * @return boolean
     */
    public function isMandatory()
    {
        return $this->mandatory;
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
    public function getOptions()
    {
        return $this->options;
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
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @return string
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @return int
     */
    public function getLengthMin()
    {
        return $this->lengthMin;
    }

    /**
     * @return int
     */
    public function getLengthMax()
    {
        return $this->lengthMax;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @return boolean
     */
    public function hasPassed()
    {
        return $this->passed;
    }

}