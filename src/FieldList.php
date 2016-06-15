<?php
namespace Creios\FormJudge;

use Creios\FormJudge\Fields\Field;
use Creios\FormJudge\Judgement\FieldListJudgement;
use Creios\FormJudge\Judgement\FieldListJudgementBuilder;

/**
 * Class FieldList
 * @package FormJudge
 */
abstract class FieldList
{

    /**
     * @var Field[] $fields
     */
    protected $fields = array();
    /**
     * @var Level[] $levels
     */
    public $levels = array();

    /**
     * @param array $post
     * @return FieldListJudgement
     */
    public function judge(array $post)
    {

        $fieldListJudgementBuilder = (new FieldListJudgementBuilder())->passed();
        foreach ($this->fields as $fieldName => $field) {
            /** @var Field $field */
            if (isset($post[$fieldName])) {
                $field->setValue($post[$fieldName]);
            }
            $fieldJudgement = $field->judge();
            $fieldListJudgementBuilder->addFieldJudgements($fieldName, $fieldJudgement);
            if ($fieldJudgement->isPassed() == false) {
                $fieldListJudgementBuilder->failed();
            }
        }

        foreach ($this->levels as $levelName => $level) {
            /** @var Level $level */
            if (isset($post[$levelName])) {
                $fieldListJudgement = $level->judge($post[$levelName]);
            } else {
                $fieldListJudgement = $level->judge(array());
            }
            if ($fieldListJudgement->isPassed() == false) {
                $fieldListJudgementBuilder->failed();
            }
            $fieldListJudgementBuilder->addFieldListJudgements($levelName, $fieldListJudgement);
        }

        return $fieldListJudgementBuilder->build();

    }

    /**
     * @param Field $field
     * @return mixed
     */
    abstract public function generateFieldName(Field $field);

    /**
     * @param Level $level
     * @return mixed
     */
    abstract public function generateLevelName(Level $level);

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
        if ($level == null) $level = new Level();
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

}
