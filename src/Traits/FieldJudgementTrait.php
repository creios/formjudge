<?php

namespace Creios\FormJudge\Traits;

/**
 * Class FieldJudgementTrait
 * @package Creios\FormJudge\Court
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
    protected $patternError = false;
    /** @var boolean */
    protected $typeError = false;
    /** @var boolean */
    protected $passed;

}