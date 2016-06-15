<?php
namespace Creios\FormJudge\Fields;

/**
 * Class Email
 * @package FormJudge\Fields
 */
class Email extends Field
{

    /**
     * @var string
     */
    protected $pattern = '^[A-Za-z0-9]+([-_\.]?[A-Za-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}$';

}
