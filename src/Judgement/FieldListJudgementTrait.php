<?php

namespace Creios\Formjudge\Judgement;

/**
 * Class FieldListJudgementTrait
 * @package Creios\Formjudge\Judgement
 */
trait FieldListJudgementTrait
{

    /** @var FieldListJudgement[] $levelJudgements */
    public $fieldListJudgements = array();
    /** @var FieldJudgement[] $fieldJudgements */
    protected $fieldJudgements = array();
    /** @var boolean */
    protected $passed;

}