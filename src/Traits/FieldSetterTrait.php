<?php

namespace Creios\FormJudge\Traits;

trait FieldSetterTrait
{

    /**
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string | float $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
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
     * @param bool $requiredConstraint
     * @return $this
     */
    public function setRequiredConstraint($requiredConstraint)
    {
        $this->requiredConstraint = $requiredConstraint;
        return $this;
    }

    /**
     * @param bool $optionalField
     * @return $this
     */
    public function setOptionalField($optionalField)
    {
        $this->optionalField = $optionalField;
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
}