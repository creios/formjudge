<?php

namespace Creios\Formjudge\Judgement;

/**
 * Class FieldJudgementTrait
 * @package Creios\Formjudge\Judgement
 */
trait FieldJudgementTrait
{

    /** @var boolean */
    protected $mandatory;
    /** @var string */
    protected $value;
    /** @var string */
    protected $pattern;
    /** @var array */
    protected $options = array();
    /** @var string */
    protected $min;
    /** @var string */
    protected $max;
    /** @var integer */
    protected $lengthMin;
    /** @var integer */
    protected $lengthMax;
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