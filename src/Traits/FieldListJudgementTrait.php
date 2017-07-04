<?php

namespace Creios\FormJudge\Traits;

use Creios\FormJudge\Court\FieldJudgement;
use Creios\FormJudge\Court\FieldListJudgement;

/**
 * Class FieldListJudgementTrait
 * @package Creios\FormJudge\Court
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