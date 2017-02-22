<?php

namespace Creios\FormJudge\Court;

use Creios\FormJudge\FieldList;
use Creios\FormJudge\Fields\Checkbox;
use Creios\FormJudge\Fields\Color;
use Creios\FormJudge\Fields\Date;
use Creios\FormJudge\Fields\DateTime;
use Creios\FormJudge\Fields\DateTimeLocal;
use Creios\FormJudge\Fields\Email;
use Creios\FormJudge\Fields\Field;
use Creios\FormJudge\Fields\Month;
use Creios\FormJudge\Fields\Number;
use Creios\FormJudge\Fields\Password;
use Creios\FormJudge\Fields\Radio;
use Creios\FormJudge\Fields\Range;
use Creios\FormJudge\Fields\Reset;
use Creios\FormJudge\Fields\Search;
use Creios\FormJudge\Fields\Tel;
use Creios\FormJudge\Fields\Text;
use Creios\FormJudge\Fields\TextArea;
use Creios\FormJudge\Fields\Time;
use Creios\FormJudge\Fields\Url;
use Creios\FormJudge\Fields\Week;
use Creios\FormJudge\Form;
use Creios\FormJudge\Level;

class Judge
{
    /**
     * @param Form $form
     * @param array $formData
     * @return FieldListJudgement
     */
    public static function judge(Form $form, array $formData)
    {
        return self::judgeFieldList($form, $formData);

    }

    /**
     * @param FieldList $fieldList
     * @param array $formData
     * @return FieldListJudgement
     */
    private static function judgeFieldList(FieldList $fieldList, array $formData)
    {
        $fieldListJudgementBuilder = (new FieldListJudgementBuilder())->setPassed(true);

        foreach ($fieldList->getFields() as $fieldName => $field) {
            /** @var Field $field */
            if (self::fieldExistsInFormData($fieldName, $formData)) {
                $value = self::getValueForFieldFromFormData($fieldName, $formData);
                $castedValue = self::parseValueBasedOnField($value, $field);
                $field->setValue($castedValue);
            }
            $fieldJudgement = self::judgeField($field);
            $fieldListJudgementBuilder->addFieldJudgements($fieldName, $fieldJudgement);
            $fieldListJudgementBuilder->setPassed($fieldJudgement->hasPassed());
        }

        foreach ($fieldList->getLevels() as $levelName => $level) {
            /** @var Level $level */
            if (self::levelExistsInFormData($levelName, $formData)) {
                $nextLevelFormData = $formData[$levelName];
            } else {
                $nextLevelFormData = [];
            }
            $fieldListJudgement = self::judgeFieldList($level, $nextLevelFormData);
            $fieldListJudgementBuilder->addFieldListJudgements($levelName, $fieldListJudgement);
            $fieldListJudgementBuilder->setPassed($fieldListJudgement->hasPassed());
        }

        return $fieldListJudgementBuilder->build();
    }

    /**
     * @param string $fieldName
     * @param array $formData
     * @return bool
     */
    private static function fieldExistsInFormData($fieldName, array $formData)
    {
        return isset($formData[$fieldName]);
    }

    /**
     * @param string $fieldName
     * @param array $formData
     * @return mixed
     */
    private static function getValueForFieldFromFormData($fieldName, array $formData)
    {
        return $formData[$fieldName];
    }

    /**
     * @param string $value
     * @param Field $field
     * @return float|int|string|null
     */
    private static function parseValueBasedOnField($value, Field $field)
    {
        // an empty string will be treated as null
        // browser send values of empty input fields as an empty string
        if (self::valueIsAnEmptyString($value)) {
            return null;
        }

        switch (true) {
            //string
            case $field instanceof Checkbox:
            case $field instanceof Color:
            case $field instanceof Date:
            case $field instanceof DateTime:
            case $field instanceof DateTimeLocal:
            case $field instanceof Email:
            case $field instanceof Password:
            case $field instanceof Radio:
            case $field instanceof Reset:
            case $field instanceof Search:
            case $field instanceof Tel:
            case $field instanceof Text:
            case $field instanceof TextArea:
            case $field instanceof Time:
            case $field instanceof Url:
                // despite that $value should be already a string we cast $value
                $castedValue = (string)$value;
                break;
            //float
            case $field instanceof Range:
            case $field instanceof Number:
                // if $value is not numeric we return $value immediately
                // the validation will take care to detect violation
                if (self::valueIsNotNumeric($value)) {
                    return $value;
                }
                // cast $value to provide accurate typing
                $castedValue = (float)$value;
                break;
            //integer
            case $field instanceof Month:
            case $field instanceof Week:
                // if $value is not numeric we return $value immediately
                // the validation will take care to detect violation
                if (self::valueIsNotNumeric($value)) {
                    return $value;
                }
                // cast $value to provide accurate typing
                $castedValue = (int)$value;
                break;
            default:
                throw new \LogicException();
        }
        return $castedValue;
    }

    /**
     * @param string $value
     * @return bool
     */
    private static function valueIsAnEmptyString($value)
    {
        return $value === "";
    }

    /**
     * @param string $value
     * @return bool
     */
    private static function valueIsNotNumeric($value)
    {
        return is_numeric($value) === false;
    }

    /**
     * @param Field $field
     * @return \Creios\FormJudge\Court\FieldJudgement
     */
    public static function judgeField(Field $field)
    {

        $fieldJudgementBuilder = (new FieldJudgementBuilder())
            ->setValue($field->getValue())
            ->setRequiredConstraint($field->getRequiredConstraint())
            ->setLengthMaxConstraint($field->getLengthMaxConstraint())
            ->setLengthMinConstraint($field->getLengthMinConstraint())
            ->setMaxConstraint($field->getMaxConstraint())
            ->setMinConstraint($field->getMinConstraint())
            ->setPatternConstraint($field->getPatternConstraint())
            ->setOptionsConstraint($field->getOptionsConstraint())
            ->setPassed(true);

        if (self::valueEqualsNull($field)) {
            $fieldJudgementBuilder->setEmpty(true);
            if (self::checkRequired($field)) {
                $fieldJudgementBuilder->setPassed(false);
            }
        } else {
            if (self::checkSyntax($field)) {
                if (!self::checkOptions($field)) $fieldJudgementBuilder->setNotInOptions(true)->setPassed(false);
                if (!self::checkRange($field)) $fieldJudgementBuilder->setOutOfRange(true)->setPassed(false);
                if (!self::checkEqualTo($field)) $fieldJudgementBuilder->setNotEqual(true)->setPassed(false);
                if (!self::checkLength($field)) $fieldJudgementBuilder->setNotPassedLength(true)->setPassed(false);
            } else {

                $fieldJudgementBuilder->setSyntaxError(true)->setPassed(false);

            }
        }
        return $fieldJudgementBuilder->build();
    }

    /**
     * @param Field $field
     * @return bool
     */
    public static function valueEqualsNull(Field $field)
    {
        return $field->getValue() === null;
    }

    /**
     * @param Field $field
     * @return bool
     */
    private static function checkRequired(Field $field)
    {
        return $field->getRequiredConstraint() === true;
    }

    /**
     * @param Field $field
     * @return bool|int
     */
    protected static function checkSyntax(Field $field)
    {
        return $field->getPatternConstraint() == null || preg_match('/' . $field->getPatternConstraint() . '/', $field->getValue());
    }

    /**
     * @param Field $field
     * @return bool
     */
    protected static function checkOptions(Field $field)
    {
        if (count($field->getOptionsConstraint()) > 0) {
            return in_array($field->getValue(), $field->getOptionsConstraint());
        } else {
            return true;
        }
    }

    /**
     * @param Field $field
     * @return bool
     */
    protected static function checkRange(Field $field)
    {
        return self::checkBoundaries($field->getValue(), $field->getMinConstraint(), $field->getMaxConstraint());
    }

    /**
     * @param $value
     * @param null $lowerBound
     * @param null $upperBound
     * @return bool
     */
    protected static function checkBoundaries($value, $lowerBound = null, $upperBound = null)
    {
        //no bound -> true
        if ($lowerBound === null && $upperBound === null):
            return true;
        //lower bound set
        elseif ($lowerBound !== null && $upperBound === null):
            return ($lowerBound <= mb_strlen($value));
        //upper bound set
        elseif ($lowerBound === null && $upperBound !== null):
            return ($upperBound >= mb_strlen($value));
        //both bounds set ($lowerBound !== null && $upperBound !== null)
        else:
            return ($lowerBound <= mb_strlen($value) && $upperBound >= mb_strlen($value));
        endif;
    }

    /**
     * @param Field $field
     * @return bool
     */
    protected static function checkEqualTo(Field $field)
    {
        if ($field->getEqualToConstraint() instanceof Field):
            return ($field->getValue() === $field->getEqualToConstraint()->getValue());
        else:
            return true;
        endif;
    }

    /**
     * @param Field $field
     * @return bool
     */
    protected static function checkLength(Field $field)
    {
        return self::checkBoundaries($field->getValue(), $field->getLengthMinConstraint(), $field->getLengthMaxConstraint());
    }

    /**
     * @param $levelName
     * @param array $formData
     * @return bool
     */
    private static function levelExistsInFormData($levelName, array $formData)
    {
        return isset($formData[$levelName]);
    }

}