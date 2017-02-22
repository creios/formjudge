<?php

namespace Creios\FormJudge\Court;

use Creios\FormJudge\Traits\FieldGetterTrait;
use Creios\FormJudge\Traits\FieldJudgementTrait;
use Creios\FormJudge\Traits\FieldSetterTrait;
use Creios\FormJudge\Traits\FieldTrait;

/**
 * Class FieldJudgementBuilder
 * @package Creios\FormJudge\Court
 */
class FieldJudgementBuilder
{

    use FieldTrait;
    use FieldGetterTrait;
    use FieldSetterTrait;
    use FieldJudgementTrait;

    /**
     * @return FieldJudgement
     */
    public function build()
    {
        return new FieldJudgement($this->requiredConstraint,
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