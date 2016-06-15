<?php
namespace Creios\Formjudge\Fields;

/**
 * Class Email
 * @package Formjudge\Fields
 */
class Email extends Field
{

    /**
     * @var string
     */
    protected $pattern = '^[A-Za-z0-9]+([-_\.]?[A-Za-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}$';

}
