<?php
namespace Creios\FormJudge\Fields;

use Creios\FormJudge\FieldList;
use Creios\FormJudge\Judgement\FieldJudgementBuilder;

/**
 * Class Field
 * @package FormJudge\Fields
 */
abstract class Field
{

    use FieldTrait;

    /** @var FieldList */
    protected $parent;
    /** @var Field */
    protected $equalToConstraint;
    /**
     * @var string
     */
    protected $type = "text";

    /**
     * @param bool $mandatoryConstraint
     */
    public function __construct($mandatoryConstraint = false)
    {
        $this->mandatoryConstraint = $mandatoryConstraint;
    }

    /**
     * @return \Creios\FormJudge\Judgement\FieldJudgement
     */
    public function judge()
    {

        $fieldJudgementBuilder = (new FieldJudgementBuilder())
            ->setValue($this->value)
            ->setMandatoryConstraint($this->mandatoryConstraint)
            ->setLengthMaxConstraint($this->lengthMaxConstraint)
            ->setLengthMinConstraint($this->lengthMinConstraint)
            ->setMaxConstraint($this->maxConstraint)
            ->setMinConstraint($this->minConstraint)
            ->setPatternConstraint($this->patternConstraint)
            ->setOptionsConstraint($this->optionsConstraint)
            ->setPassed(true);

        if ($this->equalsEmpty()) {
            $fieldJudgementBuilder->setEmpty(true);
            if ($this->mandatoryConstraint) {
                $fieldJudgementBuilder->setPassed(false);
            }
        } else {
            if ($this->checkSyntax()) {
                if (!$this->checkOptions()) $fieldJudgementBuilder->setNotInOptions(true)->setPassed(false);
                if (!$this->checkRange()) $fieldJudgementBuilder->setOutOfRange(true)->setPassed(false);
                if (!$this->checkEqualTo()) $fieldJudgementBuilder->setNotEqual(true)->setPassed(false);
                if (!$this->checkLength()) $fieldJudgementBuilder->setNotPassedLength(true)->setPassed(false);
            } else {

                $fieldJudgementBuilder->setSyntaxError(true)->setPassed(false);

            }
        }
        return $fieldJudgementBuilder->build();
    }

    /**
     * @return bool
     */
    protected function equalsEmpty()
    {
        return is_null($this->value);
    }

    /**
     * @return bool|int
     */
    protected function checkSyntax()
    {
        return $this->patternConstraint == null || preg_match('/' . $this->patternConstraint . '/', $this->value);
    }

    /**
     * @return bool
     */
    protected function checkOptions()
    {
        if (count($this->optionsConstraint) > 0) {
            return in_array($this->value, $this->optionsConstraint);
        } else {
            return true;
        }
    }

    /**
     * @return bool
     */
    protected function checkRange()
    {
        return self::checkBoundaries($this->value, $this->minConstraint, $this->maxConstraint);
    }

    /**
     * @param $value
     * @param null $lowerBound
     * @param null $upperBound
     * @return bool
     */
    protected static function checkBoundaries($value, $lowerBound = null, $upperBound = null)
    {
        //Keine Schranke gesetzt, also true
        if ($lowerBound === null && $upperBound === null):
            return true;
        //Untere Schranke gesetzt
        elseif ($lowerBound !== null && $upperBound === null):
            return ($lowerBound <= mb_strlen($value));
        //Obere Schranke gesetzt
        elseif ($lowerBound === null && $upperBound !== null):
            return ($upperBound >= mb_strlen($value));
        //Beide Schranken gesetzt ($lowerBound !== null && $upperBound !== null)
        else:
            return ($lowerBound <= mb_strlen($value) && $upperBound >= mb_strlen($value));
        endif;
    }

    /**
     * @return bool
     */
    protected function checkEqualTo()
    {
        if ($this->equalToConstraint instanceof Field):
            return ($this->value === $this->equalToConstraint->getValue());
        else:
            return true;
        endif;
    }

    /**
     * @return string
     */
    protected function getValue()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    protected function checkLength()
    {
        return self::checkBoundaries($this->value, $this->lengthMinConstraint, $this->lengthMaxConstraint);
    }

    /**
     * @param $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $optionConstraint
     * @throws \InvalidArgumentException
     */
    public function addOptionConstraint($optionConstraint)
    {
        //Setting temporarily value for checking Syntax
        $this->value = $optionConstraint;
        if (!$this->checkSyntax()):
            //Removing value
            $this->value = null;
            throw new \InvalidArgumentException("Option does not match Pattern!");
        endif;
        //Removing value
        $this->value = null;
        $this->optionsConstraint[] = $optionConstraint;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->parent->generateFieldName($this);
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
     * @param string $patternConstraint
     * @return $this
     */
    public function setPatternConstraint($patternConstraint)
    {
        $this->patternConstraint = $patternConstraint;
        return $this;
    }

    /**
     * @param array $optionsConstraint
     * @return $this
     */
    public function setOptionsConstraint($optionsConstraint)
    {
        $this->optionsConstraint = $optionsConstraint;
        return $this;
    }

    /**
     * @param bool $mandatoryConstraint
     * @return $this
     */
    public function setMandatoryConstraint($mandatoryConstraint)
    {
        $this->mandatoryConstraint = $mandatoryConstraint;
        return $this;
    }

    /**
     * @param mixed $minConstraint
     * @return $this
     */
    public function setMinConstraint($minConstraint)
    {
        $this->minConstraint = $minConstraint;
        return $this;
    }

    /**
     * @param mixed $maxConstraint
     * @return $this
     */
    public function setMaxConstraint($maxConstraint)
    {
        $this->maxConstraint = $maxConstraint;
        return $this;
    }

    /**
     * @param int $lengthMinConstraint
     * @return $this
     */
    public function setLengthMinConstraint($lengthMinConstraint)
    {
        $this->lengthMinConstraint = $lengthMinConstraint;
        return $this;
    }

    /**
     * @param int $lengthMaxConstraint
     * @return $this
     */
    public function setLengthMaxConstraint($lengthMaxConstraint)
    {
        $this->lengthMaxConstraint = $lengthMaxConstraint;
        return $this;
    }

    /**
     * @return string
     */
    public function getMinConstraint()
    {
        return $this->minConstraint;
    }

    /**
     * @return string
     */
    public function getMaxConstraint()
    {
        return $this->maxConstraint;
    }

    /**
     * @return int
     */
    public function getLengthMinConstraint()
    {
        return $this->lengthMinConstraint;
    }

    /**
     * @return int
     */
    public function getLengthMaxConstraint()
    {
        return $this->lengthMaxConstraint;
    }

    /**
     * @return string
     */
    public function getPatternConstraint()
    {
        return $this->patternConstraint;
    }

    /**
     * @return bool
     */
    public function hasMandatoryConstraint()
    {
        return $this->mandatoryConstraint;
    }

    /**
     * @return array
     */
    public function getOptionsConstraint()
    {
        return $this->optionsConstraint;
    }

}
