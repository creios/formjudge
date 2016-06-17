<?php

namespace Creios\FormJudge\Fields;

trait FieldTrait
{

    /** @var string */
    protected $value;
    /** @var boolean */
    protected $mandatoryConstraint;
    /** @var string */
    protected $patternConstraint;
    /** @var array */
    protected $optionsConstraint = array();
    /** @var string */
    protected $minConstraint;
    /** @var string */
    protected $maxConstraint;
    /** @var integer */
    protected $lengthMinConstraint;
    /** @var integer */
    protected $lengthMaxConstraint;

}