<?php
namespace Creios\FormJudge\Fields;

/**
 * Class Date
 * @package FormJudge\Fields
 */
class Date extends Field
{

    /**
     * @var string
     */
    protected $patternConstraint = '^(\d\d).(\d\d).(\d\d\d\d)$';
    /**
     * @var string
     */
    protected $type = "date";

    /**
     * @return bool
     */
    public function checkSyntax()
    {
        if (!preg_match('/' . $this->patternConstraint . '/', $this->value)):
            return false;
        endif;
        $date = explode('.', $this->value);
        return checkdate($date[1], $date[0], $date[2]);
    }

}
