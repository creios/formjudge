<?php
namespace Creios\FormJudge\Fields;

/**
 * Class Numeric
 * @package FormJudge\Fields
 */
class Numeric extends Field
{

    /**
     * @var string
     */
    protected $type = "number";

    /**
     * @return bool
     */
    protected function checkSyntax()
    {
        return is_numeric($this->value);
    }

}
