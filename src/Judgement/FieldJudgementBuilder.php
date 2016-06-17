<?php

namespace Creios\FormJudge\Judgement;

use Creios\FormJudge\Fields\FieldTrait;

/**
 * Class FieldJudgementBuilder
 * @package Creios\FormJudge\Judgement
 */
class FieldJudgementBuilder
{

    use FieldTrait;
    use FieldJudgementTrait;

    /**
     * @return FieldJudgement
     */
    public function build()
    {
        return new FieldJudgement($this->mandatoryConstraint,
            $this->value,
            $this->empty,
            $this->syntaxError,
            $this->patternConstraint,
            $this->outOfRange,
            $this->notEqual,
            $this->notPassedLength,
            $this->optionsConstraint,
            $this->notInOptions,
            $this->notInPost,
            $this->minConstraint,
            $this->maxConstraint,
            $this->lengthMinConstraint,
            $this->lengthMaxConstraint,
            $this->passed);
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
     * @param boolean $syntaxError
     * @return $this
     */
    public function setSyntaxError($syntaxError)
    {
        $this->syntaxError = $syntaxError;
        return $this;
    }

    /**
     * @param string $patternConstraint
     * @return $this
     */
    public function setPatternConstraint($patternConstraint)
    {
        $this->patternConstraint = $patternConstraint;
        return $this;
    }

    /**
     * @param array $optionsConstraint
     * @return $this
     */
    public function setOptionsConstraint($optionsConstraint)
    {
        $this->optionsConstraint = $optionsConstraint;
        return $this;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param bool $mandatoryConstraint
     * @return $this
     */
    public function setMandatoryConstraint($mandatoryConstraint)
    {
        $this->mandatoryConstraint = $mandatoryConstraint;
        return $this;
    }

    /**
     * @param mixed $minConstraint
     * @return $this
     */
    public function setMinConstraint($minConstraint)
    {
        $this->minConstraint = $minConstraint;
        return $this;
    }

    /**
     * @param mixed $maxConstraint
     * @return $this
     */
    public function setMaxConstraint($maxConstraint)
    {
        $this->maxConstraint = $maxConstraint;
        return $this;
    }

    /**
     * @param int $lengthMinConstraint
     * @return $this
     */
    public function setLengthMinConstraint($lengthMinConstraint)
    {
        $this->lengthMinConstraint = $lengthMinConstraint;
        return $this;
    }

    /**
     * @param int $lengthMaxConstraint
     * @return $this
     */
    public function setLengthMaxConstraint($lengthMaxConstraint)
    {
        $this->lengthMaxConstraint = $lengthMaxConstraint;
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