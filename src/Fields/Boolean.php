<?php
namespace Creios\FormJudge\Fields;

/**
 * Class Boolean
 * @package FormJudge\Fields
 */
class Boolean extends Field
{

    /**
     * @var string
     */
    protected $pattern = '^(0|1|TRUE|FALSE|true|false|ON|OFF|on|off)$';

    /**
     * @return int
     */
    public function checkSyntax()
    {
        return preg_match('/' . $this->pattern . '/', $this->value);
    }

}
