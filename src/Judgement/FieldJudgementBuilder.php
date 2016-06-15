<?php

namespace Creios\Formjudge\Judgement;

/**
 * Class FieldJudgementBuilder
 * @package Creios\Formjudge\Judgement
 */
class FieldJudgementBuilder
{

    use FieldJudgementTrait;

    /**
     * @return FieldJudgement
     */
    public function build()
    {
        return new FieldJudgement($this->mandatory,
            $this->value,
            $this->empty,
            $this->syntaxError,
            $this->pattern,
            $this->outOfRange,
            $this->notEqual,
            $this->notPassedLength,
            $this->options,
            $this->notInOptions,
            $this->notInPost,
            $this->min,
            $this->max,
            $this->lengthMin,
            $this->lengthMax,
            $this->passed);
    }

    /**
     * @param boolean $mandatory
     * @return $this
     */
    public function setMandatory($mandatory)
    {
        $this->mandatory = $mandatory;
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param boolean $empty
     * @return $this
     */
    public function setEmpty($empty)
    {
        $this->empty = $empty;
        return $this;
    }

    /**
     * @param boolean $syntaxError
     * @return $this
     */
    public function setSyntaxError($syntaxError)
    {
        $this->syntaxError = $syntaxError;
        return $this;
    }

    /**
     * @param string $pattern
     * @return $this
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * @param boolean $outOfRange
     * @return $this
     */
    public function setOutOfRange($outOfRange)
    {
        $this->outOfRange = $outOfRange;
        return $this;
    }

    /**
     * @param boolean $notEqual
     * @return $this
     */
    public function setNotEqual($notEqual)
    {
        $this->notEqual = $notEqual;
        return $this;
    }

    /**
     * @param boolean $notPassedLength
     * @return $this
     */
    public function setNotPassedLength($notPassedLength)
    {
        $this->notPassedLength = $notPassedLength;
        return $this;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @param boolean $notInOptions
     * @return $this
     */
    public function setNotInOptions($notInOptions)
    {
        $this->notInOptions = $notInOptions;
        return $this;
    }

    /**
     * @param boolean $notInPost
     * @return $this
     */
    public function setNotInPost($notInPost)
    {
        $this->notInPost = $notInPost;
        return $this;
    }

    /**
     * @param string $min
     * @return $this
     */
    public function setMin($min)
    {
        $this->min = $min;
        return $this;
    }

    /**
     * @param string $max
     * @return $this
     */
    public function setMax($max)
    {
        $this->max = $max;
        return $this;
    }

    /**
     * @param int $lengthMin
     * @return $this
     */
    public function setLengthMin($lengthMin)
    {
        $this->lengthMin = $lengthMin;
        return $this;
    }

    /**
     * @param int $lengthMax
     * @return $this
     */
    public function setLengthMax($lengthMax)
    {
        $this->lengthMax = $lengthMax;
        return $this;
    }

    /**
     * @param boolean $passed
     * @return $this
     */
    public function setPassed($passed)
    {
        $this->passed = $passed;
        return $this;
    }

    /**
     * @return $this
     */
    public function passed()
    {
        $this->passed = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function failed()
    {
        $this->passed = false;
        return $this;
    }

}