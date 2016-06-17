<?php

namespace Creios\FormJudge;

use Creios\FormJudge\Fields\Field;

/**
 * Class Form
 * @package FormJudge
 */
class Form extends FieldList
{

    /**
     * @param Field $field
     * @return mixed
     */
    public function generateFieldName(Field $field)
    {
        return array_search($field, $this->fields, TRUE);
    }

    /**
     * @param Level $level
     * @return mixed
     */
    public function generateLevelName(Level $level)
    {
        return array_search($level, $this->levels, TRUE);
    }

}
