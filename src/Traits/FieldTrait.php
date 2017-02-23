<?php

namespace Creios\FormJudge\Traits;

trait FieldTrait
{

    /** @var integer | string | float */
    protected $value;
    /** @var boolean */
    protected $requiredConstraint;
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