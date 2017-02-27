<?php

namespace Creios\FormJudge\Factories;

class MySqlFieldFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateMethods()
    {
        $field = MySqlFieldFactory::createDate();
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertFalse($field->getRequiredConstraint());
        $this->assertNull($field->getValue());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertSame('string', $field->getType());
        $this->assertSame(MySqlFieldFactory::DATE_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertSame(MySqlFieldFactory::DATE_MIN_CONSTRAINT, $field->getMinConstraint());
        $this->assertSame(MySqlFieldFactory::DATE_PATTERN_CONSTRAINT, $field->getPatternConstraint());

        $field = MySqlFieldFactory::createDate(True);
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertNull($field->getValue());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertSame('string', $field->getType());
        $this->assertSame(MySqlFieldFactory::DATE_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertSame(MySqlFieldFactory::DATE_MIN_CONSTRAINT, $field->getMinConstraint());
        $this->assertSame(MySqlFieldFactory::DATE_PATTERN_CONSTRAINT, $field->getPatternConstraint());
        $this->assertTrue($field->getRequiredConstraint());

        $field = MySqlFieldFactory::createTextTextArea();
        $this->assertEquals(MySqlFieldFactory::TEXT_LENGTH_MAX_CONSTRAINT, $field->getLengthMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertFalse($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertNull($field->getMinConstraint());
        $this->assertNull($field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('string', $field->getType());
        $this->assertNull($field->getMaxConstraint());

        $field = MySqlFieldFactory::createTextTextArea(True);
        $this->assertEquals(MySqlFieldFactory::TEXT_LENGTH_MAX_CONSTRAINT, $field->getLengthMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertNull($field->getMinConstraint());
        $this->assertNull($field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('string', $field->getType());
        $this->assertNull($field->getMaxConstraint());
        $this->assertTrue($field->getRequiredConstraint());

        $field = MySqlFieldFactory::createTextInput();
        $this->assertEquals(MySqlFieldFactory::TEXT_LENGTH_MAX_CONSTRAINT, $field->getLengthMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertFalse($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertNull($field->getMinConstraint());
        $this->assertNull($field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('string', $field->getType());
        $this->assertNull($field->getMaxConstraint());

        $field = MySqlFieldFactory::createTextInput(True);
        $this->assertEquals(MySqlFieldFactory::TEXT_LENGTH_MAX_CONSTRAINT, $field->getLengthMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertNull($field->getMinConstraint());
        $this->assertNull($field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('string', $field->getType());
        $this->assertNull($field->getMaxConstraint());
        $this->assertTrue($field->getRequiredConstraint());

        $field = MySqlFieldFactory::createSignedBigInt();
        $this->assertEquals(MySqlFieldFactory::BIGINT_SIGNED_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertFalse($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertEquals('-?[0-9]+', $field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('int', $field->getType());
        $this->assertSame(MySqlFieldFactory::BIGINT_SIGNED_MIN_CONSTRAINT, $field->getMinConstraint());

        $field = MySqlFieldFactory::createSignedBigInt(True);
        $this->assertEquals(MySqlFieldFactory::BIGINT_SIGNED_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertTrue($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertEquals('-?[0-9]+', $field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('int', $field->getType());
        $this->assertSame(MySqlFieldFactory::BIGINT_SIGNED_MIN_CONSTRAINT, $field->getMinConstraint());

        $field = MySqlFieldFactory::createSignedInt();
        $this->assertEquals(MySqlFieldFactory::INT_SIGNED_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertFalse($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertEquals('-?[0-9]+', $field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('int', $field->getType());
        $this->assertSame(MySqlFieldFactory::INT_SIGNED_MIN_CONSTRAINT, $field->getMinConstraint());

        $field = MySqlFieldFactory::createSignedInt(True);
        $this->assertEquals(MySqlFieldFactory::INT_SIGNED_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertTrue($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertEquals('-?[0-9]+', $field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('int', $field->getType());
        $this->assertSame(MySqlFieldFactory::INT_SIGNED_MIN_CONSTRAINT, $field->getMinConstraint());

        $field = MySqlFieldFactory::createSignedMediumInt();
        $this->assertEquals(MySqlFieldFactory::MEDIUMINT_SIGNED_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertFalse($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertEquals('-?[0-9]+', $field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('int', $field->getType());
        $this->assertSame(MySqlFieldFactory::MEDIUMINT_SIGNED_MIN_CONSTRAINT, $field->getMinConstraint());

        $field = MySqlFieldFactory::createSignedMediumInt(True);
        $this->assertEquals(MySqlFieldFactory::MEDIUMINT_SIGNED_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertTrue($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertEquals('-?[0-9]+', $field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('int', $field->getType());
        $this->assertSame(MySqlFieldFactory::MEDIUMINT_SIGNED_MIN_CONSTRAINT, $field->getMinConstraint());

        $field = MySqlFieldFactory::createSignedSmallInt();
        $this->assertEquals(MySqlFieldFactory::SMALLINT_SIGNED_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertFalse($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertEquals('-?[0-9]+', $field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('int', $field->getType());
        $this->assertSame(MySqlFieldFactory::SMALLINT_SIGNED_MIN_CONSTRAINT, $field->getMinConstraint());

        $field = MySqlFieldFactory::createSignedSmallInt(True);
        $this->assertEquals(MySqlFieldFactory::SMALLINT_SIGNED_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertTrue($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertEquals('-?[0-9]+', $field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('int', $field->getType());
        $this->assertSame(MySqlFieldFactory::SMALLINT_SIGNED_MIN_CONSTRAINT, $field->getMinConstraint());

        $field = MySqlFieldFactory::createSignedTinyInt();
        $this->assertEquals(MySqlFieldFactory::TINYINT_SIGNED_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertFalse($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertEquals('-?[0-9]+', $field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('int', $field->getType());
        $this->assertSame(MySqlFieldFactory::TINYINT_SIGNED_MIN_CONSTRAINT, $field->getMinConstraint());

        $field = MySqlFieldFactory::createSignedTinyInt(True);
        $this->assertEquals(MySqlFieldFactory::TINYINT_SIGNED_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertTrue($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertEquals('-?[0-9]+', $field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('int', $field->getType());
        $this->assertSame(MySqlFieldFactory::TINYINT_SIGNED_MIN_CONSTRAINT, $field->getMinConstraint());

        $field = MySqlFieldFactory::createUnsignedBigInt();
        $this->assertEquals(MySqlFieldFactory::BIGINT_UNSIGNED_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertFalse($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertEquals('-?[0-9]+', $field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('int', $field->getType());
        $this->assertSame(MySqlFieldFactory::BIGINT_UNSIGNED_MIN_CONSTRAINT, $field->getMinConstraint());

        $field = MySqlFieldFactory::createUnsignedBigInt(True);
        $this->assertEquals(MySqlFieldFactory::BIGINT_UNSIGNED_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertTrue($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertEquals('-?[0-9]+', $field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('int', $field->getType());
        $this->assertSame(MySqlFieldFactory::BIGINT_UNSIGNED_MIN_CONSTRAINT, $field->getMinConstraint());

        $field = MySqlFieldFactory::createUnsignedInt();
        $this->assertEquals(MySqlFieldFactory::INT_UNSIGNED_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertFalse($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertEquals('-?[0-9]+', $field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('int', $field->getType());
        $this->assertSame(MySqlFieldFactory::INT_UNSIGNED_MIN_CONSTRAINT, $field->getMinConstraint());

        $field = MySqlFieldFactory::createUnsignedInt(True);
        $this->assertEquals(MySqlFieldFactory::INT_UNSIGNED_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertTrue($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertEquals('-?[0-9]+', $field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('int', $field->getType());
        $this->assertSame(MySqlFieldFactory::INT_UNSIGNED_MIN_CONSTRAINT, $field->getMinConstraint());

        $field = MySqlFieldFactory::createUnsignedMediumInt();
        $this->assertEquals(MySqlFieldFactory::MEDIUMINT_UNSIGNED_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertFalse($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertEquals('-?[0-9]+', $field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('int', $field->getType());
        $this->assertSame(MySqlFieldFactory::MEDIUMINT_UNSIGNED_MIN_CONSTRAINT, $field->getMinConstraint());

        $field = MySqlFieldFactory::createUnsignedMediumInt(True);
        $this->assertEquals(MySqlFieldFactory::MEDIUMINT_UNSIGNED_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertTrue($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertEquals('-?[0-9]+', $field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('int', $field->getType());
        $this->assertSame(MySqlFieldFactory::MEDIUMINT_UNSIGNED_MIN_CONSTRAINT, $field->getMinConstraint());

        $field = MySqlFieldFactory::createUnsignedSmallInt();
        $this->assertEquals(MySqlFieldFactory::SMALLINT_UNSIGNED_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertFalse($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertEquals('-?[0-9]+', $field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('int', $field->getType());
        $this->assertSame(MySqlFieldFactory::SMALLINT_UNSIGNED_MIN_CONSTRAINT, $field->getMinConstraint());

        $field = MySqlFieldFactory::createUnsignedSmallInt(True);
        $this->assertEquals(MySqlFieldFactory::SMALLINT_UNSIGNED_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertTrue($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertEquals('-?[0-9]+', $field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('int', $field->getType());
        $this->assertSame(MySqlFieldFactory::SMALLINT_UNSIGNED_MIN_CONSTRAINT, $field->getMinConstraint());

        $field = MySqlFieldFactory::createUnsignedTinyInt();
        $this->assertEquals(MySqlFieldFactory::TINYINT_UNSIGNED_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertFalse($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertEquals('-?[0-9]+', $field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('int', $field->getType());
        $this->assertSame(MySqlFieldFactory::TINYINT_UNSIGNED_MIN_CONSTRAINT, $field->getMinConstraint());

        $field = MySqlFieldFactory::createUnsignedTinyInt(True);
        $this->assertEquals(MySqlFieldFactory::TINYINT_UNSIGNED_MAX_CONSTRAINT, $field->getMaxConstraint());
        $this->assertEquals([], $field->getOptionsConstraint());
        $this->assertTrue($field->getRequiredConstraint());
        $this->assertNull($field->getEqualToConstraint());
        $this->assertNull($field->getLengthMaxConstraint());
        $this->assertNull($field->getLengthMinConstraint());
        $this->assertEquals('-?[0-9]+', $field->getPatternConstraint());
        $this->assertNull($field->getValue());
        $this->assertSame('int', $field->getType());
        $this->assertSame(MySqlFieldFactory::TINYINT_UNSIGNED_MIN_CONSTRAINT, $field->getMinConstraint());

    }

}
