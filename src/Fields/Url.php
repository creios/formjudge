<?php
namespace Creios\FormJudge\Fields;

/**
 * Class Url
 * @package FormJudge\Fields
 */
class Url extends Field
{

    /**
     * @var string
     */
    protected $pattern = '^[A-Za-z0-9-]+(\\.[A-Za-z0-9-]+)*(\\.[A-Za-z]{2,})$';

}
