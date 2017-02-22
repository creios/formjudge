<?php

namespace Creios\FormJudge\Generator;

use Creios\FormJudge\Fields\Field;
use PHPUnit_Framework_MockObject_MockObject;

class FieldGeneratorTest extends \PHPUnit_Framework_TestCase
{

    /** @var PHPUnit_Framework_MockObject_MockObject|Field */
    private $field;

    public function setUp()
    {
        $this->field = $this->createMock(Field::class);
    }

    public function testGenerate()
    {
        $this->field->method('getType')->willReturn('email');
        $this->field->method('getLengthMaxConstraint')->willReturn(null);
        $this->field->method('getLengthMinConstraint')->willReturn(null);
        $this->field->method('getMaxConstraint')->willReturn(null);
        $this->field->method('getMinConstraint')->willReturn(null);
        $this->field->method('hasMandatoryConstraint')->willReturn(false);
        $this->field->method('getPatternConstraint')->willReturn(null);
        $fieldGenerator = new FieldGenerator($this->field);
        $expectedFieldAttributes = 'type="email" ';
        $this->assertEquals($expectedFieldAttributes, $fieldGenerator->generate());
    }
}
