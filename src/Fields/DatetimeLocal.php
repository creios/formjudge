<?php
namespace Creios\FormJudge\Fields;

/**
 * Class DatetimeLocal
 * @package FormJudge\Fields
 */
class DatetimeLocal extends Field
{

    /**
     * @var string
     */
    protected $pattern = '^(\d\d\d\d)-(\d\d)-(\d\d)T([01]?\d|2[0-3]):([0-5]?\d):([0-5]?\d)$';

    /**
     * @return bool
     */
    public function checkSyntax()
    {
        if (!preg_match('/' . $this->pattern . '/', $this->value)):
            return FALSE;
        endif;
        $dateTime = explode('T', $this->value);
        $date = explode('-', $dateTime[0]);
        $day = $date[2];
        $month = $date[1];
        $year = $date[0];
        return checkdate($month, $day, $year);
    }

}
