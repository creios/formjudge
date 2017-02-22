<?php
namespace Creios\FormJudge\Fields;

/**
 * Class Textarea
 * @package FormJudge\Fields
 */
class Textarea extends Field
{

    /**
     * @var string
     */
    protected $patternConstraint = '^(.*)$';

    /**
     * @return bool
     */
    protected function equalsEmpty()
    {
        return empty($this->value);
    }

}
