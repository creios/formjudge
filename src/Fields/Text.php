<?php
namespace Creios\FormJudge\Fields;

/**
 * Class Text
 * @package FormJudge\Fields
 */
class Text extends Field
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
