<?php
namespace Creios\FormJudge\Fields;

/**
 * Class TextArea
 * @package FormJudge\Fields
 */
class TextArea extends Field
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
