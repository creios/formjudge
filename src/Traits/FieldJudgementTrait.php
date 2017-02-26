<?php

namespace Creios\FormJudge\Traits;

/**
 * Class FieldJudgementTrait
 * @package Creios\FormJudge\Court
 */
trait FieldJudgementTrait
{

    /** @var boolean */
    protected $outOfRange;
    /** @var boolean */
    protected $notEqual;
    /** @var boolean */
    protected $notPassedLength;
    /** @var boolean */
    protected $notInOptions;
    /** @var boolean */
    protected $notInPost;
    /** @var boolean */
    protected $empty;
    /** @var boolean */
    protected $patternError;
    /** @var boolean */
    protected $typeError;
    /** @var boolean */
    protected $passed;

}