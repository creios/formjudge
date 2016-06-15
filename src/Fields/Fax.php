<?php
namespace Creios\Formjudge\Fields;

/**
 * Class Fax
 * @package Formjudge\Fields
 */
class Fax extends Field
{

    /**
     * @var string
     */
    protected $pattern = '^[+](\d{1,}) ([1-9]{1})(\d{1,}) (\d{1,})-?(\d{1,})$';

    /**
     * @return string
     */
    public function getType()
    {
        return "tel";
    }

}
