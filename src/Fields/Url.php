<?php
namespace Creios\Formjudge\Fields;

/**
 * Class Url
 * @package Formjudge\Fields
 */
class Url extends Field
{

    /**
     * @var string
     */
    protected $pattern = '^[A-Za-z0-9-]+(\\.[A-Za-z0-9-]+)*(\\.[A-Za-z]{2,})$';

}
