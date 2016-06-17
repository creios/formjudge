<?php

namespace Creios\FormJudge\Fields;

trait FieldTrait
{

    /** @var boolean */
    protected $mandatory;
    /** @var string */
    protected $value;
    /** @var string */
    protected $pattern;
    /** @var array */
    protected $options = array();
    /** @var string */
    protected $min;
    /** @var string */
    protected $max;
    /** @var integer */
    protected $lengthMin;
    /** @var integer */
    protected $lengthMax;
    
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

}