<?php

namespace Creios\FormJudge\Generator;

class FieldListGenerator
{

    /**
     * @var FieldListGenerator[] $levels
     */
    public $levelGenerators = array();
    /**
     * @var FieldGenerator[] $fields
     */
    protected $fieldGenerators = array();

    /**
     * @param FieldGenerator[] $fieldGenerators
     * @param FieldListGenerator[] $levelGenerators
     */
    public function __construct(array $fieldGenerators, array $levelGenerators)
    {
        $this->fieldGenerators = $fieldGenerators;
        $this->levelGenerators = $levelGenerators;
    }

    /**
     * @param $name
     * @return FieldGenerator
     */
    public function getField($name)
    {
        return $this->fieldGenerators[$name];
    }

    /**
     * @param $name
     * @return FieldListGenerator
     */
    public function getLevel($name)
    {
        return $this->levelGenerators[$name];
    }
}