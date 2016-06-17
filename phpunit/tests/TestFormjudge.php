<?php

namespace Creios\FormJudge;

use Creios\FormJudge\Fields\Boolean;
use Creios\FormJudge\Fields\Date;
use Creios\FormJudge\Fields\DatetimeLocal;
use Creios\FormJudge\Fields\Email;
use Creios\FormJudge\Fields\Fax;
use Creios\FormJudge\Fields\Mobile;
use Creios\FormJudge\Fields\Numeric;
use Creios\FormJudge\Fields\Password;
use Creios\FormJudge\Fields\Tel;
use Creios\FormJudge\Fields\Text;
use Creios\FormJudge\Fields\Time;
use Creios\FormJudge\Fields\Url;

class TestFormJudge extends \PHPUnit_Framework_TestCase
{

    public function testNotValidFormular()
    {
        $formContact = new Formular();
        $formContact->addField("supportarea", new Numeric(TRUE));
        $judgement = $formContact->judge(array());
        $this->assertFalse($judgement->hasPassed());

    }

    public function testNotValidFormular2()
    {
        $form = new Formular();
        $form->addLevel("USER", new Level());
        $form->getLevel("USER")->addField("id", new Numeric(TRUE));
        $form->addLevel("EMPTY", new Level());
        $form->getLevel("EMPTY")->addField("empty", new Text(TRUE));
        $judgement = $form->judge(array("USER" => array("id" => "nichtNumerisch")));
        $this->assertFalse($judgement->hasPassed());
    }

    public function testPasswordConfirmation()
    {
        $oFieldsForm1 = new Formular();
        $oFieldsForm1->addLevel('password', new Level());
        $oFieldsForm1->getLevel('password')->addField('new', new Text(TRUE));
        $oFieldsForm1->getLevel('password')->addField('confirm', new Text(TRUE));
        $oFieldsForm1->getLevel('password')->getField('confirm')->setEqualToConstraint($oFieldsForm1->getLevel('password')->getField('new'));
        $post['password']['new'] = "test";
        $post['password']['confirm'] = "test";
        $judgement = $oFieldsForm1->judge($post);
        $this->assertTrue($judgement->hasPassed());
    }

    public function testContactData()
    {
        $formContact = new Formular();
        $formContact->addField("supportarea", new Numeric(TRUE));
        $formContact->getField("supportarea")->addOptionConstraint("0");
        $formContact->getField("supportarea")->addOptionConstraint("1");
        $formContact->addField("message", new Text(TRUE));
        $formContact->addField("gender", new Text(TRUE));
        $formContact->getField("gender")->addOptionConstraint("M");
        $formContact->getField("gender")->addOptionConstraint("F");
        $formContact->addField("firstname", new Text(TRUE));
        $formContact->addField("lastname", new Text(TRUE));
        $formContact->addField('email', new Email(TRUE));
        $formContact->addField('company', new Numeric(TRUE));

        $post['supportarea'] = "1";
        $post['message'] = "test";
        $post['gender'] = "M";
        $post['firstname'] = "sdasada";
        $post['lastname'] = "Limper";
        $post['email'] = "teeees@dsdsd.tld";
        $post['company'] = "1";

        $judgement = $formContact->judge($post);
        $this->assertTrue($judgement->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement('supportarea')->isNotInOptions());
        $this->assertEquals(["0", "1"], $judgement->getFieldJudgement('supportarea')->getOptionsConstraint());
        $this->assertFalse($judgement->getFieldJudgement('supportarea')->isNotInPost());
    }

    public function testField()
    {
        $formContact = new Formular();
        //range
        $formContact->addField("fromTo", new Numeric(TRUE));
        $formContact->getField("fromTo")->setMinConstraint(0);
        $formContact->getField("fromTo")->setMaxConstraint(10);
        //length
        $formContact->addField("length", new Numeric(TRUE));
        $formContact->getField("length")->setLengthMinConstraint(0);
        $formContact->getField("length")->setLengthMaxConstraint(5);
        //options
        $post['fromTo'] = 10;
        $post['length'] = 2;
        $judgement = $formContact->judge($post);
        $this->assertTrue($judgement->hasPassed());
        $this->assertEquals('0', $judgement->getFieldJudgement("fromTo")->getMinConstraint());
        $this->assertEquals('10', $judgement->getFieldJudgement("fromTo")->getMaxConstraint());
        $this->assertEquals('0', $judgement->getFieldJudgement("length")->getLengthMinConstraint());
        $this->assertEquals('5', $judgement->getFieldJudgement("length")->getLengthMaxConstraint());
        $this->assertFalse($judgement->getFieldJudgement("length")->isNotPassedLength());
    }

    public function testGenerateFieldName()
    {
        $formContact = new Formular();
        $formContact->addField("supportArea", new Numeric(TRUE));
        $formContact->addLevel("newLevel");
        $formContact->getLevel("newLevel")->addField("test", new Email())->setMandatoryConstraint(TRUE);
        $formContact->getLevel("newLevel")->addLevel("secondLevel")->addField("test", new Email());
        $this->assertEquals("supportArea", $formContact->getField("supportArea")->getName());
        $this->assertEquals("newLevel[test]", $formContact->getLevel("newLevel")->getField("test")->getName());
        $this->assertEquals("newLevel[secondLevel][test]", $formContact->getLevel("newLevel")->getLevel("secondLevel")->getField("test")->getName());
    }

    public function testJson()
    {
        $formContact = new Formular();
        $formContact->addField("supportArea", new Numeric(TRUE));
        $formContact->addLevel("newLevel");
        $formContact->getLevel("newLevel")->addField("test", new Email())->setMandatoryConstraint(TRUE);
        $formContact->getLevel("newLevel")->addLevel("secondLevel")->addField("test", new Email());
    }

    public function testOptionPattern()
    {
        $formContact = new Formular();
        $formContact->addField("supportarea", new Numeric(TRUE));
        $this->setExpectedException("Exception", "Option does not match Pattern!");
        $formContact->getField("supportarea")->addOptionConstraint("falsch");
    }

    public function testBoolean()
    {
        $post['true'] = "true";
        $post['false'] = "false";
        $formular = new Formular();
        $formular->addField('true', new Boolean(TRUE));
        $formular->addField('false', new Boolean(TRUE));
        $this->assertTrue($formular->judge($post)->hasPassed());
    }

    public function testDate()
    {
        $post['date'] = "12.05.1987";
        $formular = new Formular();
        $formular->addField('date', new Date(TRUE));
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->hasPassed());
        $post['date'] = "425.544.1987";
        $judgement = $formular->judge($post);
        $this->assertFalse($judgement->hasPassed());
        $this->assertEquals('Date', $formular->getField('date')->getType());
    }

    public function testPassword()
    {
        $post['password'] = 'test123';
        $formular = new Formular();
        $formular->addField('password', new Password(TRUE));
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->hasPassed());
        $post['password'] = 'test12345678910112';
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->hasPassed());
        $post['password'] = '1';
        $judgement = $formular->judge($post);
        $this->assertFalse($judgement->hasPassed());
    }

    public function testDatetimeLocal()
    {
        $formular = new Formular();
        $formular->addField('date', new DatetimeLocal(TRUE));
        $post['date'] = "2015-10-15T15:15:15";
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->hasPassed());
        $post['date'] = "2015-10-15Tb5:15:15";
        $judgement = $formular->judge($post);
        $this->assertFalse($judgement->hasPassed());
        $post['date'] = "2015-10-63T15:15:15";
        $judgement = $formular->judge($post);
        $this->assertFalse($judgement->hasPassed());
    }

    public function testEmail()
    {
        $post = ['user'];
        $post['user']['email'] = "tegeler@creios.net";
        $formular = new Formular();
        $formular->addLevel('user', new Level());
        $formular->getLevel('user')->addField('email', new Email(TRUE));
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->hasPassed());
        $this->assertEquals('^[A-Za-z0-9]+([-_\.]?[A-Za-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}$', $judgement->getFieldListJudgement('user')->getFieldJudgement('email')->getPatternConstraint());
    }

    public function testFax()
    {
        $post['fax'] = "+49 123 12-123";
        $formular = new Formular();
        $formular->addField('fax', new Fax(true));
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->hasPassed());
        $this->assertEquals('tel', $formular->getField('fax')->getType());
    }

    public function testMobile()
    {
        $post['mobile'] = "+49 923 1212";
        $formular = new Formular();
        $formular->addField('mobile', new Mobile(true));
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->hasPassed());
        $this->assertEquals('tel', $formular->getField('mobile')->getType());
    }

    public function testTel()
    {
        $post['tel'] = "+49 923 12423-344";
        $formular = new Formular();
        $formular->addField('tel', new Tel());
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->hasPassed());
    }

    public function testTelFailed()
    {
        $post['tel'] = "not a number";
        $formular = new Formular();
        $formular->addField('tel', new Tel(true));
        $judgement = $formular->judge($post);
        $this->assertFalse($judgement->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement("tel")->isSyntaxError());
        $this->assertTrue($judgement->getFieldJudgement("tel")->hasMandatoryConstraint());
        $this->assertEquals("not a number", $judgement->getFieldJudgement("tel")->getValue());
        $this->assertFalse($judgement->getFieldJudgement("tel")->isEmpty());
    }

    public function testText()
    {
        $post['text'] = "abcdef";
        $formular = new Formular();
        $formular->addField('text', new Text());
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->hasPassed());
    }

    public function testTime()
    {
        $post['time'] = "11:45";
        $formular = new Formular();
        $formular->addField('time', new Time());
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->hasPassed());
    }

    public function testUrl()
    {
        $post['url'] = "remondis.de";
        $formular = new Formular();
        $formular->addField('url', new Url());
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->hasPassed());
    }

    public function testNumeric()
    {
        $post['numeric'] = "2";
        $formular = new Formular();
        $formular->addField('numeric', new Numeric(TRUE));
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->hasPassed());
    }

    public function testField2()
    {
        $formContact = new Formular();
        $formContact->addField("length", new Numeric(TRUE));
        $formContact->getField("length")->setLengthMinConstraint(0);
        $formContact->getField("length")->setLengthMaxConstraint(5);
    }

    public function testMinMaxField()
    {
        $formContact = new Formular();
        //range
        $formContact->addField("lowerBound", new Numeric(TRUE));
        $formContact->getField("lowerBound")->setMinConstraint(0);
        $post['lowerBound'] = 0;
        $formContact->addField("upperBound", new Numeric(TRUE));
        $formContact->getField("upperBound")->setMaxConstraint(2);
        $post['upperBound'] = 1;
        $formContact->addField("lowerUpperBound", new Numeric(TRUE));
        $formContact->getField("lowerUpperBound")->setMinConstraint(0);
        $formContact->getField("lowerUpperBound")->setMaxConstraint(2);
        $post['lowerUpperBound'] = 1;
        $judgement = $formContact->judge($post);
        $this->assertTrue($judgement->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement("lowerBound")->isOutOfRange());
    }

    public function testLengthMinLengthMaxField()
    {
        $formContact = new Formular();
        //range
        $formContact->addField("lowerBound", new Text(TRUE));
        $formContact->getField("lowerBound")->setLengthMinConstraint(0);
        $post['lowerBound'] = "Max";
        $formContact->addField("upperBound", new Text(TRUE));
        $formContact->getField("upperBound")->setLengthMaxConstraint(3);
        $post['upperBound'] = "Max";
        $formContact->addField("lowerUpperBound", new Text(TRUE));
        $formContact->getField("lowerUpperBound")->setLengthMinConstraint(0);
        $formContact->getField("lowerUpperBound")->setLengthMaxConstraint(3);
        $post['lowerUpperBound'] = "Max";
        $this->assertTrue($formContact->judge($post)->hasPassed());
    }
}
