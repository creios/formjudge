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

    /** @var boolean */
    protected $mandatory;
    /** @var string */
    protected $value;
    /** @var string */
    protected $pattern;
    /** @var string */
    protected $min;
    /** @var string */
    protected $max;
    /** @var integer */
    protected $lengthMin;
    /** @var integer */
    protected $lengthMax;
    /** @var FieldList */
    protected $parent;
    /** @var Field */
    protected $equalTo;
    protected $options = array();
    /** @var bool */
    protected $empty = false;

    /**
     * @param bool $mandatory
     */
    public function __construct($mandatory = false)
    {
        $this->mandatory = $mandatory;
    }

    /**
     * @return \Creios\FormJudge\Judgement\FieldJudgement
     */
    public function judge()
    {

        $fieldJudgemenBuilder = (new FieldJudgementBuilder())
            ->setMandatory($this->mandatory)
            ->setEmpty($this->empty)
            ->setLengthMax($this->lengthMax)
            ->setLengthMin($this->lengthMin)
            ->setMax($this->max)
            ->setMin($this->min)
            ->setPattern($this->pattern)
            ->setPassed(true);

        if ($this->isValueEmpty()) {
            if ($this->mandatory) {
                $fieldJudgemenBuilder->setEmpty(true);
                $fieldJudgemenBuilder->setPassed(false);
            }
        } else {
            if ($this->checkSyntax()) {
                if (!$this->checkOptions()) $fieldJudgemenBuilder->setNotInOptions(true)->setPassed(false);
                if (!$this->checkRange()) $fieldJudgemenBuilder->setOutOfRange(true)->setPassed(false);
                if (!$this->checkEqualTo()) $fieldJudgemenBuilder->setNotEqual(true)->setPassed(false);
                if (!$this->checkLength()) $fieldJudgemenBuilder->setNotPassedLength(true)->setPassed(false);
            } else {

                $fieldJudgemenBuilder->setSyntaxError(true)->setPassed(false);

            }
        }
        return $fieldJudgemenBuilder->build();
    }

    /**
     * @return bool
     */
    private function isValueEmpty()
    {
        if (is_numeric($this->value) && $this->value == 0):
            return false;
        endif;
        return empty($this->value);
    }

    /**
     * @return bool|int
     */
    protected function checkSyntax()
    {
        return $this->pattern == null || preg_match('/' . $this->pattern . '/', $this->value);
    }

    /**
     * @return bool
     */
    protected function checkOptions()
    {
        if (count($this->options) > 0) {
            return in_array($this->value, $this->options);
        } else {
            return true;
        }
    }

    /**
     * @return bool
     */
    protected function checkRange()
    {
        return self::checkBoundaries($this->value, $this->min, $this->max);
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
        if ($this->equalTo instanceof Field):
            return ($this->value === $this->equalTo->getValue());
        else:
            return true;
        endif;
    }

    /**
     * @return bool
     */
    protected function checkLength()
    {
        return self::checkBoundaries($this->value, $this->lengthMin, $this->lengthMax);
    }

    /**
     * @return string
     */
    protected function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return str_replace(["_", __NAMESPACE__ . "\\"], ["-", ""], get_class($this));
    }

    /**
     * @param $option
     * @throws \InvalidArgumentException
     */
    public function addOption($option)
    {
        //Setting temporarily value for checking Syntax
        $this->value = $option;
        if (!$this->checkSyntax()):
            //Removing value
            $this->value = null;
            throw new \InvalidArgumentException("Option does not match Pattern!");
        endif;
        //Removing value
        $this->value = null;
        $this->options[] = $option;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->parent->generateFieldName($this);
    }

    /**
     * @param $mandatory
     * @return $this
     */
    public function setMandatory($mandatory)
    {
        $this->mandatory = $mandatory;
        return $this;
    }

    /**
     * @param Field $equalTo
     * @return $this
     */
    public function setEqualTo(Field $equalTo)
    {
        $this->equalTo = $equalTo;
        return $this;
    }

    /**
     * @param mixed $min
     * @return $this
     */
    public function setMin($min)
    {
        $this->min = $min;
        return $this;
    }

    /**
     * @param mixed $max
     * @return $this
     */
    public function setMax($max)
    {
        $this->max = $max;
        return $this;
    }

    /**
     * @param int $lengthMin
     * @return $this
     */
    public function setLengthMin($lengthMin)
    {
        $this->lengthMin = $lengthMin;
        return $this;
    }

    /**
     * @param int $lengthMax
     * @return $this
     */
    public function setLengthMax($lengthMax)
    {
        $this->lengthMax = $lengthMax;
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
