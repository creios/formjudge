<?php
namespace Creios\Formjudge\Fields;

/**
 * Class Numeric
 * @package Formjudge\Fields
 */
class Numeric extends Field
{

    /**
     * @return bool
     */
    protected function checkSyntax()
    {
        return is_numeric($this->value);
    }

}
