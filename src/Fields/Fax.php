<?php
namespace Creios\FormJudge\Fields;

/**
 * Class Fax
 * @package FormJudge\Fields
 */
class Fax extends Field
{

    /**
     * @var string
     */
    protected $patternConstraint = '^[+](\d{1,}) ([1-9]{1})(\d{1,}) (\d{1,})-?(\d{1,})$';

    /**
     * @return string
     */
    public function getType()
    {
        return "tel";
    }

}
