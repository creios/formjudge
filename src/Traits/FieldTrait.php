<?php

namespace Creios\FormJudge\Traits;

trait FieldTrait
{

    /** @var string */
    protected $type;
    /** @var string | float */
    protected $value;
    /** @var boolean */
    protected $optionalField;
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
    /** @var int */
    protected $lengthMinConstraint;
    /** @var int */
    protected $lengthMaxConstraint;

}