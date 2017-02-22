<?php

namespace Creios\FormJudge\Generator;

use Creios\FormJudge\Fields\Email;

class FieldGeneratorTest extends \PHPUnit_Framework_TestCase
{

    public function testGenerate()
    {
        $field = new Email();
        $fieldGenerator = new FieldGenerator($field);
        $expectedFieldAttributes = 'type="email" pattern="^[A-Za-z0-9]+([-_\.]?[A-Za-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}$"';
        $this->assertEquals($expectedFieldAttributes, $fieldGenerator->generate());
    }

}
