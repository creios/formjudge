<?php

namespace Creios\FormJudge;

use Creios\FormJudge\Fields\Field;

/**
 * Class Level
 * @package FormJudge
 */
class Level extends FieldList
{

    /** @var Level */
    private $parent;

    /**
     * @param $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @param Field $field
     * @return string
     */
    public function generateFieldName(Field $field)
    {
        return $this->parent->generateLevelName($this) . "[" . array_search($field, $this->fields, TRUE) . "]";
    }

    /**
     * @param Level $level
     * @return string
     */
    public function generateLevelName(Level $level)
    {
        return $this->parent->generateLevelName($this) . "[" . array_search($level, $this->levels, TRUE) . "]";
    }

}
