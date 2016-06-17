<?php
namespace Creios\FormJudge\Fields;

/**
 * Class Mobile
 * @package FormJudge\Fields
 */
class Mobile extends Field
{

    /**
     * @var string
     */
    protected $patternConstraint = '^[+](\d{1,}) ([1-9]{1})(\d{1,}) (\d{1,})$';

    /**
     * @return string
     */
    public function getType()
    {
        return "tel";
    }

}
