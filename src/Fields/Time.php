<?php
namespace Creios\Formjudge\Fields;

/**
 * Class Time
 * @package Formjudge\Fields
 */
class Time extends Field
{

    /**
     * @var string
     */
    protected $pattern = '^([01]?\d|2[0-3]):([0-5]?\d)$';

    /**
     * @return int
     */
    public function checkSyntax()
    {
        return preg_match('/' . $this->pattern . '/', $this->value);
    }

}