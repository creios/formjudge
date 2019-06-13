<?php
namespace Creios\FormJudge\Fields;

use Creios\FormJudge\FieldList;
use Creios\FormJudge\Traits\FieldGetterTrait;
use Creios\FormJudge\Traits\FieldSetterTrait;
use Creios\FormJudge\Traits\FieldTrait;

/**
 * Class Field
 * @package FormJudge\Fields
 */
abstract class Field
{

    use FieldTrait;
    use FieldSetterTrait;
    use FieldGetterTrait;

    /**
     * @var string
     */
    const FIELD_DEFAULT_TYPE = 'string';
    /** @var FieldList */
    protected $parent;
    /** @var Field */
    protected $equalToConstraint;

    /**
     * @param bool $requiredConstraint
     */
    protected function __construct($requiredConstraint = false, $optionalField = false)
    {
        $this->requiredConstraint = $requiredConstraint;
        $this->optionalField = $optionalField;
    }

    /**
     * @param bool $requiredConstraint
     * @return static
     */
    public static function createInstance($requiredConstraint = false, $optionalField = false)
    {
        return (new static($requiredConstraint, $optionalField))->setType(self::FIELD_DEFAULT_TYPE);
    }

    /**
     * @param $optionConstraint
     * @return $this
     */
    public function addOptionConstraint($optionConstraint)
    {
        $castedOptionConstraint = null;
        switch ($this->getType()) {
            case 'string':
                $castedOptionConstraint = (string) $optionConstraint;
                break;
            case 'float':
                $castedOptionConstraint = (float) $optionConstraint;
                if(!is_numeric($optionConstraint) || $optionConstraint != $castedOptionConstraint) {
                    throw new \InvalidArgumentException("Given option constraint has to match field type");
                }
                break;
            case 'int':
                $castedOptionConstraint = (int) $optionConstraint;
                if(!is_numeric($optionConstraint) || $optionConstraint != $castedOptionConstraint) {
                    throw new \InvalidArgumentException("Given option constraint has to match field type");
                }
                break;
            default:
                throw new \LogicException("Only 'string', 'int' and 'float' are valid values");
        }
        $this->optionsConstraint[] = $castedOptionConstraint;
        return $this;
    }

    /**
     * @return Field
     */
    public function getEqualToConstraint()
    {
        return $this->equalToConstraint;
    }

    /**
     * @param Field $equalToConstraint
     * @return $this
     */
    public function setEqualToConstraint(Field $equalToConstraint)
    {
        $this->equalToConstraint = $equalToConstraint;
        return $this;
    }

    /**
     * @param FieldList $parent
     * @return $this
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

}
