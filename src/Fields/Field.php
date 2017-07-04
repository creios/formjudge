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
    protected function __construct($requiredConstraint = false)
    {
        $this->requiredConstraint = $requiredConstraint;
    }

    /**
     * @param bool $requiredConstraint
     * @return static
     */
    public static function createInstance($requiredConstraint = false)
    {
        return (new static($requiredConstraint))->setType(self::FIELD_DEFAULT_TYPE);
    }

    /**
     * @param $optionConstraint
     * @return $this
     */
    public function addOptionConstraint($optionConstraint)
    {
        $this->optionsConstraint[] = $optionConstraint;
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
