<?php

namespace Creios\FormJudge\Factories;

use Creios\FormJudge\Fields\Date;
use Creios\FormJudge\Fields\Numeric;
use Creios\FormJudge\Fields\Text;
use Creios\FormJudge\Fields\Textarea;

/**
 * Class MySqlFieldFactory
 * @package Creios\FormJudge\Factories
 */
class MySqlFieldFactory
{
    const TINYINT_SIGNED_MIN_CONSTRAINT = -128;
    const TINYINT_SIGNED_MAX_CONSTRAINT = 127;
    const TINYINT_UNSIGNED_MIN_CONSTRAINT = 0;
    const TINYINT_UNSIGNED_MAX_CONSTRAINT = 255;
    const SMALLINT_SIGNED_MIN_CONSTRAINT = -32768;
    const SMALLINT_SIGNED_MAX_CONSTRAINT = 32767;
    const SMALLINT_UNSIGNED_MIN_CONSTRAINT = 0;
    const SMALLINT_UNSIGNED_MAX_CONSTRAINT = 65535;
    const MEDIUMINT_SIGNED_MIN_CONSTRAINT = -8388608;
    const MEDIUMINT_SIGNED_MAX_CONSTRAINT = 8388607;
    const MEDIUMINT_UNSIGNED_MIN_CONSTRAINT = 0;
    const MEDIUMINT_UNSIGNED_MAX_CONSTRAINT = 16777215;
    const INT_SIGNED_MIN_CONSTRAINT = -2147483648;
    const INT_SIGNED_MAX_CONSTRAINT = 2147483647;
    const INT_UNSIGNED_MIN_CONSTRAINT = 0;
    const INT_UNSIGNED_MAX_CONSTRAINT = 4294967295;
    const BIGINT_SIGNED_MIN_CONSTRAINT = -9223372036854775808;
    const BIGINT_SIGNED_MAX_CONSTRAINT = 9223372036854775807;
    const BIGINT_UNSIGNED_MIN_CONSTRAINT = 0;
    const BIGINT_UNSIGNED_MAX_CONSTRAINT = 18446744073709551615;
    const TEXT_LENGTH_MAX_CONSTRAINT = 21844;
    const DATE_PATTERN_CONSTRAINT = '^\d\d\d\d-\d\d-\d\d)$';
    const DATE_MIN_CONSTRAINT = '1000-01-01';
    const DATE_MAX_CONSTRAINT = '9999-12-31';

    /**
     * @param bool $mandatoryConstraint
     * @return Numeric
     */
    public static function createSignedTinyInt($mandatoryConstraint = false)
    {
        return (new Numeric($mandatoryConstraint))
            ->setMinConstraint(self::TINYINT_SIGNED_MIN_CONSTRAINT)
            ->setMaxConstraint(self::TINYINT_SIGNED_MAX_CONSTRAINT);
    }

    /**
     * @param bool $mandatoryConstraint
     * @return Numeric
     */
    public static function createUnsignedTinyInt($mandatoryConstraint = false)
    {
        return (new Numeric($mandatoryConstraint))
            ->setMinConstraint(self::TINYINT_UNSIGNED_MIN_CONSTRAINT)
            ->setMaxConstraint(self::TINYINT_UNSIGNED_MAX_CONSTRAINT);
    }

    /**
     * @param bool $mandatoryConstraint
     * @return Numeric
     */
    public static function createSignedMediumInt($mandatoryConstraint = false)
    {
        return (new Numeric($mandatoryConstraint))
            ->setMinConstraint(self::MEDIUMINT_SIGNED_MIN_CONSTRAINT)
            ->setMaxConstraint(self::MEDIUMINT_SIGNED_MAX_CONSTRAINT);
    }

    /**
     * @param bool $mandatoryConstraint
     * @return Numeric
     */
    public static function createUnsignedMediumInt($mandatoryConstraint = false)
    {
        return (new Numeric($mandatoryConstraint))
            ->setMinConstraint(self::MEDIUMINT_UNSIGNED_MIN_CONSTRAINT)
            ->setMaxConstraint(self::MEDIUMINT_UNSIGNED_MAX_CONSTRAINT);
    }

    /**
     * @param bool $mandatoryConstraint
     * @return Numeric
     */
    public static function createSignedInt($mandatoryConstraint = false)
    {
        return (new Numeric($mandatoryConstraint))
            ->setMinConstraint(self::INT_SIGNED_MIN_CONSTRAINT)
            ->setMaxConstraint(self::INT_SIGNED_MAX_CONSTRAINT);
    }

    /**
     * @param bool $mandatoryConstraint
     * @return Numeric
     */
    public static function createUnsignedInt($mandatoryConstraint = false)
    {
        return (new Numeric($mandatoryConstraint))
            ->setMinConstraint(self::INT_UNSIGNED_MIN_CONSTRAINT)
            ->setMaxConstraint(self::INT_UNSIGNED_MAX_CONSTRAINT);
    }

    /**
     * @param bool $mandatoryConstraint
     * @return Numeric
     */
    public static function createSignedBigInt($mandatoryConstraint = false)
    {
        return (new Numeric($mandatoryConstraint))
            ->setMinConstraint(self::BIGINT_SIGNED_MIN_CONSTRAINT)
            ->setMaxConstraint(self::BIGINT_SIGNED_MAX_CONSTRAINT);
    }

    /**
     * @param bool $mandatoryConstraint
     * @return Numeric
     */
    public static function createUnsignedBigInt($mandatoryConstraint = false)
    {
        return (new Numeric($mandatoryConstraint))
            ->setMinConstraint(self::BIGINT_UNSIGNED_MIN_CONSTRAINT)
            ->setMaxConstraint(self::BIGINT_UNSIGNED_MAX_CONSTRAINT);
    }

    /**
     * @param bool $mandatoryConstraint
     * @return Text
     */
    public static function createTextInput($mandatoryConstraint = false)
    {
        return (new Text($mandatoryConstraint))
            ->setLengthMaxConstraint(self::TEXT_LENGTH_MAX_CONSTRAINT);
    }

    /**
     * @param bool $mandatoryConstraint
     * @return Textarea
     */
    public static function createTextTextarea($mandatoryConstraint = false)
    {
        return (new Textarea($mandatoryConstraint))
            ->setLengthMaxConstraint(self::TEXT_LENGTH_MAX_CONSTRAINT);
    }

    /**
     * @param bool $mandatoryConstraint
     * @return Date
     */
    public static function createDate($mandatoryConstraint = false)
    {
        return (new Date($mandatoryConstraint))
            ->setPatternConstraint(self::DATE_PATTERN_CONSTRAINT)
            ->setMinConstraint(self::DATE_MIN_CONSTRAINT)
            ->setMaxConstraint(self::DATE_MAX_CONSTRAINT);
    }

}