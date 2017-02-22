<?php

namespace Creios\FormJudge\Fields;

class DateTimeLocal extends Field
{
    protected $patternConstraint = '^[0-9]{4}-(((0[13578]|(10|12))-(0[1-9]|[1-2][0-9]|3[0-1]))|(02-(0[1-9]|[1-2][0-9]))|((0[469]|11)-(0[1-9]|[1-2][0-9]|30)))T([01]?\d|2[0-3]):([0-5]?\d):([0-5]?\d)$';
}