<?php

namespace Creios\FormJudge\Court;

use Creios\FormJudge\Traits\FieldListJudgementTrait;

/**
 * Class FieldListJudgementBuilder
 * @package Creios\FormJudge\Court
 */
class FieldListJudgementBuilder
{

    use FieldListJudgementTrait;

    /**
     * @return FieldListJudgement
     */
    public function build()
    {
        return new FieldListJudgement($this->fieldJudgements, $this->fieldListJudgements, $this->passed);
    }

    /**
     * @param $name
     * @param FieldJudgement $fieldJudgements
     */
    public function addFieldJudgement($name, FieldJudgement $fieldJudgements)
    {
        $this->fieldJudgements[$name] = $fieldJudgements;
    }

    /**
     * @param $name
     * @param FieldListJudgement $fieldListJudgements
     */
    public function addFieldListJudgement($name, FieldListJudgement $fieldListJudgements)
    {
        $this->fieldListJudgements[$name] = $fieldListJudgements;
    }

    /**
     * @param bool $passed
     * @return FieldListJudgementBuilder
     */
    public function setPassed($passed)
    {
        $this->passed = $passed;
        return $this;
    }

}