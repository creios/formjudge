<?php
namespace Creios\FormJudge\Fields;

/**
 * Class Tel
 * @package FormJudge\Fields
 */
class Tel extends Field
{

    /**
     * @var string
     */
    protected $pattern = '^[+](\d{1,}) ([1-9]{1})(\d{1,}) (\d{1,})-?(\d{1,})$';

}
