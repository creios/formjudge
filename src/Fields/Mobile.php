<?php
namespace Creios\Formjudge\Fields;

/**
 * Class Mobile
 * @package Formjudge\Fields
 */
class Mobile extends Field
{

    /**
     * @var string
     */
    protected $pattern = '^[+](\d{1,}) ([1-9]{1})(\d{1,}) (\d{1,})$';

    /**
     * @return string
     */
    public function getType()
    {
        return "tel";
    }

}
