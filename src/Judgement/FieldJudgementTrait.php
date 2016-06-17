<?php

namespace Creios\FormJudge\Judgement;

/**
 * Class FieldJudgementTrait
 * @package Creios\FormJudge\Judgement
 */
trait FieldJudgementTrait
{

    /** @var boolean */
    protected $outOfRange = false;
    /** @var boolean */
    protected $notEqual = false;
    /** @var boolean */
    protected $notPassedLength = false;
    /** @var boolean */
    protected $notInOptions = false;
    /** @var boolean */
    protected $notInPost = false;
    /** @var boolean */
    protected $empty = false;
    /** @var boolean */
    protected $syntaxError = false;
    /** @var boolean */
    protected $passed;

}