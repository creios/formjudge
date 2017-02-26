<?php

namespace Creios\FormJudge\Court;

use Creios\FormJudge\FieldList;
use Creios\FormJudge\Fields\Field;
use Creios\FormJudge\Form;
use Creios\FormJudge\Level;

class Judge
{

    /**
     * @param Form $form
     * @param array $formData
     * @return FieldListJudgement
     * @throws \LogicException
     */
    public static function judge(Form $form, array $formData)
    {
        return self::judgeFieldList($form, $formData);

    }

    /**
     * @param FieldList $fieldList
     * @param array $formData
     * @return FieldListJudgement
     * @throws \LogicException
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
            if ($fieldJudgement->hasPassed() === false) {
                $fieldListJudgementBuilder->setPassed(false);
            }
        }

        foreach ($fieldList->getLevels() as $levelName => $level) {
            $nextLevelFormData = [];
            /** @var Level $level */
            if (self::levelExistsInFormData($levelName, $formData)) {
                $nextLevelFormData = $formData[$levelName];
            }
            $fieldListJudgement = self::judgeFieldList($level, $nextLevelFormData);
            $fieldListJudgementBuilder->addFieldListJudgements($levelName, $fieldListJudgement);
            if ($fieldListJudgement->hasPassed() === false) {
                $fieldListJudgementBuilder->setPassed($fieldListJudgement->hasPassed());
            }
        }

        return $fieldListJudgementBuilder->build();
    }

    /**
     * @param Field $field
     * @return \Creios\FormJudge\Court\FieldJudgement
     * @throws \LogicException
     */
    private static function judgeField(Field $field)
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

            if (self::checkType($field)) {

                if (self::checkPattern($field)) {

                    if (!self::checkOptions($field)) {
                        $fieldJudgementBuilder->setNotInOptions(true)->setPassed(false);
                    }
                    if (!self::checkRange($field)) {
                        $fieldJudgementBuilder->setOutOfRange(true)->setPassed(false);
                    }
                    if (!self::checkEqualTo($field)) {
                        $fieldJudgementBuilder->setNotEqual(true)->setPassed(false);
                    }
                    if (!self::checkLength($field)) {
                        $fieldJudgementBuilder->setNotPassedLength(true)->setPassed(false);
                    }

                } else {
                    $fieldJudgementBuilder->setPatternError(true)->setPassed(false);
                }

            } else {
                $fieldJudgementBuilder->setTypeError(true)->setPassed(false);
            }
        }

        return $fieldJudgementBuilder->build();
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
     * @throws \LogicException
     */
    private static function parseValueBasedOnField($value, Field $field)
    {
        // an empty string will be treated as null
        // browser send values of empty input fields as an empty string
        if (self::valueIsAnEmptyString($value)) {
            return null;
        }

        switch ($field->getType()) {
            case 'string':
                // despite that $value should be already a string we cast $value
                $castedValue = (string)$value;
                break;
            case 'int':
                // if $value is not numeric we return $value immediately
                // the validation will take care to detect violation
                if (self::valueIsNotNumeric($value)) {
                    return $value;
                }
                // cast $value to provide accurate typing
                $castedValue = (int)$value;
                break;
            case 'float':
                // if $value is not numeric we return $value immediately
                // the validation will take care to detect violation
                if (self::valueIsNotNumeric($value)) {
                    return $value;
                }
                // cast $value to provide accurate typing
                $castedValue = (float)$value;
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
     * @return bool
     */
    private static function valueEqualsNull(Field $field)
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
     * @return bool
     * @throws \LogicException
     */
    private static function checkType(Field $field)
    {
        switch ($field->getType()) {
            case 'string':
                return is_string($field->getValue());
                break;
            case 'int':
                return is_int($field->getValue());
                break;
            case 'float':
                return is_float($field->getValue());
                break;
            default:
                throw new \LogicException();
        }
    }

    /**
     * @param Field $field
     * @return bool|int
     */
    private static function checkPattern(Field $field)
    {
        return $field->getPatternConstraint() === null || preg_match('/' . $field->getPatternConstraint() . '/', $field->getValue());
    }

    /**
     * @param Field $field
     * @return bool
     */
    private static function checkOptions(Field $field)
    {
        if (count($field->getOptionsConstraint()) > 0) {
            return in_array($field->getValue(), $field->getOptionsConstraint(), true);
        } else {
            return true;
        }
    }

    /**
     * @param Field $field
     * @return bool
     */
    private static function checkEqualTo(Field $field)
    {
        if ($field->getEqualToConstraint() instanceof Field):
            return ($field->getValue() === $field->getEqualToConstraint()->getValue());
        else:
            return true;
        endif;
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

    /**
     * @param Field $field
     * @return bool
     */
    private static function checkLength(Field $field)
    {
        return self::checkBoundaries(mb_strlen($field->getValue()), $field->getLengthMinConstraint(), $field->getLengthMaxConstraint());
    }

    /**
     * @param Field $field
     * @return bool
     */
    private static function checkRange(Field $field)
    {
        return self::checkBoundaries($field->getValue(), $field->getMinConstraint(), $field->getMaxConstraint());
    }

    /**
     * @param $value
     * @param null $lowerBound
     * @param null $upperBound
     * @return bool
     */
    private static function checkBoundaries($value, $lowerBound = null, $upperBound = null)
    {
        //no bound -> true
        if ($lowerBound === null && $upperBound === null) {
            return true;
        } else {
            $result = true;
            //lower bound set
            if ($lowerBound !== null) {
                $result = $result && ($lowerBound <= $value);
            }
            //upper bound set
            if ($upperBound !== null) {
                $result = $result && ($upperBound >= $value);
            }
            return $result;
        }
    }

}