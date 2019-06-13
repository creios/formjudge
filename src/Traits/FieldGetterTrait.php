<?php

namespace Creios\FormJudge\Traits;

trait FieldGetterTrait
{

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string | float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public function getOptionsConstraint()
    {
        return $this->optionsConstraint;
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
     * @return bool
     */
    public function getRequiredConstraint()
    {
        return $this->requiredConstraint;
    }

    /**
     * @return bool
     */
    public function getOptionalField()
    {
        return $this->optionalField;
    }
}