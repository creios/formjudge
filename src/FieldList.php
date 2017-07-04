<?php
namespace Creios\FormJudge;

use Creios\FormJudge\Fields\Field;
use Creios\FormJudge\Generator\FieldGenerator;
use Creios\FormJudge\Generator\FormGenerator;

/**
 * Class FieldList
 * @package FormJudge
 */
abstract class FieldList
{

    /**
     * @var Level[] $levels
     */
    protected $levels = array();
    /**
     * @var Field[] $fields
     */
    protected $fields = array();

    /** @return FormGenerator */
    public function getGenerator()
    {
        $fieldGenerators = [];
        foreach ($this->fields as $fieldName => $field) {
            $fieldGenerators[$fieldName] = new FieldGenerator($field);
        }

        $levelGenerators = [];
        foreach ($this->levels as $levelName => $level) {
            $levelGenerators[$levelName] = $level->getGenerator();
        }

        return new FormGenerator($fieldGenerators, $levelGenerators);
    }

    /**
     * @param $name
     * @param Field $field
     * @return Field
     */
    public function addField($name, Field $field)
    {
        $this->fields[$name] = $field;
        $field->setParent($this);
        return $field;
    }

    /**
     * @param $name
     * @param Level|null $level
     * @return Level
     */
    public function addLevel($name, Level $level = null)
    {
        if ($level === null) {
            $level = new Level();
        }
        $this->levels[$name] = $level;
        $level->setParent($this);
        return $level;
    }

    /**
     * @param $name
     * @return Field
     */
    public function getField($name)
    {
        return $this->fields[$name];
    }

    /**
     * @param $name
     * @return Level
     */
    public function getLevel($name)
    {
        return $this->levels[$name];
    }

    /**
     * @return Field[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return Level[]
     */
    public function getLevels()
    {
        return $this->levels;
    }

}
