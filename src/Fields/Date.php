<?php
namespace Creios\Formjudge\Fields;

/**
 * Class Date
 * @package Formjudge\Fields
 */
class Date extends Field
{

    /**
     * @var string
     */
    protected $pattern = '^(\d\d).(\d\d).(\d\d\d\d)$';

    /**
     * @return bool
     */
    public function checkSyntax()
    {
        if (!preg_match('/' . $this->pattern . '/', $this->value)):
            return false;
        endif;
        $date = explode('.', $this->value);
        return checkdate($date[1], $date[0], $date[2]);
    }

}
