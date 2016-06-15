<?php

namespace Creios\FormJudge\Judgement;

/**
 * Class FieldListJudgementTrait
 * @package Creios\FormJudge\Judgement
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