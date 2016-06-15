<?php

namespace Creios\FormJudge\Judgement;

/**
 * Class FieldListJudgementBuilder
 * @package Creios\FormJudge\Judgement
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
    public function addFieldJudgements($name, FieldJudgement $fieldJudgements)
    {
        $this->fieldJudgements[$name] = $fieldJudgements;
    }

    /**
     * @param $name
     * @param FieldListJudgement $fieldListJudgements
     */
    public function addFieldListJudgements($name, FieldListJudgement $fieldListJudgements)
    {
        $this->fieldListJudgements[$name] = $fieldListJudgements;
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