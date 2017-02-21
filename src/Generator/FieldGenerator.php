<?php

namespace Creios\FormJudge\Generator;

use Creios\FormJudge\Fields\Field;
use Creios\FormJudge\Fields\Textarea;

class FieldGenerator
{

    /** @var Field */
    private $field;

    /**
     * FieldGenerator constructor.
     * @param Field $field
     */
    public function __construct(Field $field)
    {
        $this->field = $field;
    }

    /**
     * @return string
     */
    public function generate()
    {
        $fieldAttributes = $this->generateType();
        $fieldAttributes .= $this->generateMaxConstraint();
        $fieldAttributes .= $this->generateMinConstraint();
        $fieldAttributes .= $this->generateLengthMaxConstraint();
        $fieldAttributes .= $this->generateLengthMinConstraint();
        $fieldAttributes .= $this->generatePatternConstraint();
        $fieldAttributes .= $this->generateMandatoryConstraint();
        return $fieldAttributes;
    }

    /**
     * @return string
     */
    private function generateType()
    {
        if ($this->field instanceof Textarea) {
            return "";
        }
        return sprintf('type="%s" ', $this->field->getType());
    }

    /**
     * @return string
     */
    private function generateMaxConstraint()
    {
        if ($this->field->getMaxConstraint() === null) {
            return "";
        }
        return sprintf('max="%s" ', $this->field->getMaxConstraint());
    }

    /**
     * @return string
     */
    private function generateMinConstraint()
    {
        if ($this->field->getMinConstraint() === null) {
            return "";
        }
        return sprintf('min="%s" ', $this->field->getMinConstraint());
    }

    /**
     * @return string
     */
    private function generateLengthMaxConstraint()
    {
        if ($this->field->getLengthMaxConstraint() === null) {
            return "";
        }
        return sprintf('maxlength="%s" ', $this->field->getLengthMaxConstraint());
    }

    /**
     * @return string
     */
    private function generateLengthMinConstraint()
    {
        if ($this->field->getLengthMinConstraint() === null) {
            return "";
        }
        return sprintf('minlength="%s" ', $this->field->getLengthMaxConstraint());
    }

    /**
     * @return string
     */
    private function generatePatternConstraint()
    {
        if ($this->field->getPatternConstraint() === null) {
            return "";
        }
        return sprintf('pattern="%s" ', $this->field->getPatternConstraint());
    }

    /**
     * @return string
     */
    private function generateMandatoryConstraint()
    {
        if ($this->field->hasMandatoryConstraint() === null) {
            return "";
        }
        return "required ";
    }
}