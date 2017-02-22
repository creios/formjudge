<?php
namespace Creios\FormJudge\Fields;

/**
 * Class Date
 * @package FormJudge\Fields
 */
class Date extends Field
{

    protected $patternConstraint = '^[0-9]{4}-(((0[13578]|(10|12))-(0[1-9]|[1-2][0-9]|3[0-1]))|(02-(0[1-9]|[1-2][0-9]))|((0[469]|11)-(0[1-9]|[1-2][0-9]|30)))$';

}
