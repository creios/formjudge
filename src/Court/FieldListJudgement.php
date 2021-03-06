<?php

namespace Creios\FormJudge\Court;

use Creios\FormJudge\Traits\FieldListJudgementTrait;

/**
 * Class FieldListJudgement
 * @package Creios\FormJudge\Court
 */
class FieldListJudgement
{

    use FieldListJudgementTrait;

    /**
     * FieldListJudgement constructor.
     * @param FieldJudgement[] $fieldJudgements
     * @param FieldListJudgement[] $fieldListJudgements
     * @param bool $passed
     */
    public function __construct(array $fieldJudgements, array $fieldListJudgements, $passed)
    {
        $this->fieldJudgements = $fieldJudgements;
        $this->fieldListJudgements = $fieldListJudgements;
        $this->passed = $passed;
    }

    /**
     * @return FieldJudgement[]
     */
    public function getFieldJudgements()
    {
        return $this->fieldJudgements;
    }

    /**
     * @param $name
     * @return FieldJudgement
     * @throws \InvalidArgumentException
     */
    public function getFieldJudgement($name)
    {
        if (isset($this->fieldJudgements[$name]) === false) {
            throw new \InvalidArgumentException("No value with key '$name' available");
        }
        return $this->fieldJudgements[$name];
    }

    /**
     * @return FieldListJudgement[]
     */
    public function getFieldListJudgements()
    {
        return $this->fieldListJudgements;
    }

    /**
     * @param $name
     * @return FieldListJudgement
     * @throws \InvalidArgumentException
     */
    public function getFieldListJudgement($name)
    {
        if (isset($this->fieldListJudgements[$name]) === false) {
            throw new \InvalidArgumentException("No value with key '$name' available");
        }
        return $this->fieldListJudgements[$name];
    }

    /**
     * @return boolean
     */
    public function hasPassed()
    {
        return $this->passed;
    }

}