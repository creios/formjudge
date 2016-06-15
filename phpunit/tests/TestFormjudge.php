<?php
namespace Creios\Formjudge;

use Creios\Formjudge\Fields\Boolean;
use Creios\Formjudge\Fields\Date;
use Creios\Formjudge\Fields\DatetimeLocal;
use Creios\Formjudge\Fields\Email;
use Creios\Formjudge\Fields\Fax;
use Creios\Formjudge\Fields\Mobile;
use Creios\Formjudge\Fields\Numeric;
use Creios\Formjudge\Fields\Password;
use Creios\Formjudge\Fields\Tel;
use Creios\Formjudge\Fields\Text;
use Creios\Formjudge\Fields\Time;
use Creios\Formjudge\Fields\Url;

class TestFormjudge extends \PHPUnit_Framework_TestCase
{

    public function testNotValidFormular()
    {
        $formContact = new Formular();
        $formContact->addField("supportarea", new Numeric(TRUE));
        $judgement = $formContact->judge(array());
        $this->assertFalse($judgement->isPassed());

    }

    public function testNotValidFormular2()
    {
        $form = new Formular();
        $form->addLevel("USER", new Level());
        $form->getLevel("USER")->addField("id", new Numeric(TRUE));
        $form->addLevel("EMPTY", new Level());
        $form->getLevel("EMPTY")->addField("empty", new Text(TRUE));
        $judgement = $form->judge(array("USER" => array("id" => "nichtNumerisch")));
        $this->assertFalse($judgement->isPassed());
    }

    public function testPasswordConfirmation()
    {
        $oFieldsForm1 = new Formular();
        $oFieldsForm1->addLevel('password', new Level());
        $oFieldsForm1->getLevel('password')->addField('new', new Text(TRUE));
        $oFieldsForm1->getLevel('password')->addField('confirm', new Text(TRUE));
        $oFieldsForm1->getLevel('password')->getField('confirm')->setEqualTo($oFieldsForm1->getLevel('password')->getField('new'));
        $post['password']['new'] = "test";
        $post['password']['confirm'] = "test";
        $judgement = $oFieldsForm1->judge($post);
        $this->assertTrue($judgement->isPassed());
    }

    public function testContactData()
    {
        $formContact = new Formular();
        $formContact->addField("supportarea", new Numeric(TRUE));
        $formContact->getField("supportarea")->addOption("0");
        $formContact->getField("supportarea")->addOption("1");
        $formContact->addField("message", new Text(TRUE));
        $formContact->addField("gender", new Text(TRUE));
        $formContact->getField("gender")->addOption("M");
        $formContact->getField("gender")->addOption("F");
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
        $this->assertTrue($formContact->judge($post)->isPassed());

    }

    public function testField()
    {
        $formContact = new Formular();
        //range
        $formContact->addField("fromTo", new Numeric(TRUE));
        $formContact->getField("fromTo")->setMin(0);
        $formContact->getField("fromTo")->setMax(10);
        //length
        $formContact->addField("length", new Numeric(TRUE));
        $formContact->getField("length")->setLengthMin(0);
        $formContact->getField("length")->setLengthMax(5);
        //options
        $post['fromTo'] = 10;
        $post['length'] = 2;
        $judgement = $formContact->judge($post);
        $this->assertTrue($judgement->isPassed());
        $this->assertEquals('0', $judgement->getFieldJudgement("fromTo")->getMin());
        $this->assertEquals('10', $judgement->getFieldJudgement("fromTo")->getMax());
    }

    public function testGenerateFieldName()
    {
        $formContact = new Formular();
        $formContact->addField("supportArea", new Numeric(TRUE));
        $formContact->addLevel("newLevel");
        $formContact->getLevel("newLevel")->addField("test", new Email())->setMandatory(TRUE);
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
        $formContact->getLevel("newLevel")->addField("test", new Email())->setMandatory(TRUE);
        $formContact->getLevel("newLevel")->addLevel("secondLevel")->addField("test", new Email());
    }

    public function testOptionPattern()
    {
        $formContact = new Formular();
        $formContact->addField("supportarea", new Numeric(TRUE));
        $this->setExpectedException("Exception", "Option does not match Pattern!");
        $formContact->getField("supportarea")->addOption("falsch");
    }

    public function testBoolean()
    {
        $post['true'] = "true";
        $post['false'] = "false";
        $formular = new Formular();
        $formular->addField('true', new Boolean(TRUE));
        $formular->addField('false', new Boolean(TRUE));
        $this->assertTrue($formular->judge($post)->isPassed());
    }

    public function testDate()
    {
        $post['date'] = "12.05.1987";
        $formular = new Formular();
        $formular->addField('date', new Date(TRUE));
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->isPassed());
        $post['date'] = "425.544.1987";
        $judgement = $formular->judge($post);
        $this->assertFalse($judgement->isPassed());
        $this->assertEquals('Date', $formular->getField('date')->getType());
    }

    public function testPassword()
    {
        $post['password'] = 'test123';
        $formular = new Formular();
        $formular->addField('password', new Password(TRUE));
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->isPassed());
        $post['password'] = 'test12345678910112';
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->isPassed());
        $post['password'] = '1';
        $judgement = $formular->judge($post);
        $this->assertFalse($judgement->isPassed());
    }

    public function testDatetimeLocal()
    {
        $formular = new Formular();
        $formular->addField('date', new DatetimeLocal(TRUE));
        $post['date'] = "2015-10-15T15:15:15";
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->isPassed());
        $post['date'] = "2015-10-15Tb5:15:15";
        $judgement = $formular->judge($post);
        $this->assertFalse($judgement->isPassed());
        $post['date'] = "2015-10-63T15:15:15";
        $judgement = $formular->judge($post);
        $this->assertFalse($judgement->isPassed());
    }

    public function testEmail()
    {
        $post = ['user'];
        $post['user']['email'] = "tegeler@creios.net";
        $formular = new Formular();
        $formular->addLevel('user', new Level());
        $formular->getLevel('user')->addField('email', new Email(TRUE));
        $judgement=$formular->judge($post);
        $this->assertTrue($judgement->isPassed());
        $this->assertEquals('^[A-Za-z0-9]+([-_\.]?[A-Za-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}$', $judgement->getFieldListJudgement('user')->getFieldJudgement('email')->getPattern());
    }

    public function testFax()
    {
        $post['fax'] = "+49 123 12-123";
        $formular = new Formular();
        $formular->addField('fax', new Fax(true));
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->isPassed());
        $this->assertEquals('tel', $formular->getField('fax')->getType());
    }

    public function testMobile()
    {
        $post['mobile'] = "+49 923 1212";
        $formular = new Formular();
        $formular->addField('mobile', new Mobile(true));
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->isPassed());
        $this->assertEquals('tel', $formular->getField('mobile')->getType());
    }

    public function testTel()
    {
        $post['tel'] = "+49 923 12423-344";
        $formular = new Formular();
        $formular->addField('tel', new Tel());
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->isPassed());
    }

    public function testText()
    {
        $post['text'] = "abcdef";
        $formular = new Formular();
        $formular->addField('text', new Text());
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->isPassed());
    }

    public function testTime()
    {
        $post['time'] = "11:45";
        $formular = new Formular();
        $formular->addField('time', new Time());
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->isPassed());
    }

    public function testUrl()
    {
        $post['url'] = "remondis.de";
        $formular = new Formular();
        $formular->addField('url', new Url());
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->isPassed());
    }

    public function testNumeric()
    {
        $post['numeric'] = "2";
        $formular = new Formular();
        $formular->addField('numeric', new Numeric(TRUE));
        $judgement = $formular->judge($post);
        $this->assertTrue($judgement->isPassed());
    }

    public function testField2()
    {
        $formContact = new Formular();
        $formContact->addField("length", new Numeric(TRUE));
        $formContact->getField("length")->setLengthMin(0);
        $formContact->getField("length")->setLengthMax(5);
    }

    public function testMinMaxField()
    {
        $formContact = new Formular();
        //range
        $formContact->addField("lowerBound", new Numeric(TRUE));
        $formContact->getField("lowerBound")->setMin(0);
        $post['lowerBound'] = 0;
        $formContact->addField("upperBound", new Numeric(TRUE));
        $formContact->getField("upperBound")->setMax(2);
        $post['upperBound'] = 1;
        $formContact->addField("lowerUpperBound", new Numeric(TRUE));
        $formContact->getField("lowerUpperBound")->setMin(0);
        $formContact->getField("lowerUpperBound")->setMax(2);
        $post['lowerUpperBound'] = 1;
        $this->assertTrue($formContact->judge($post)->isPassed());
    }

    public function testLengthMinLengthMaxField()
    {
        $formContact = new Formular();
        //range
        $formContact->addField("lowerBound", new Text(TRUE));
        $formContact->getField("lowerBound")->setLengthMin(0);
        $post['lowerBound'] = "Max";
        $formContact->addField("upperBound", new Text(TRUE));
        $formContact->getField("upperBound")->setLengthMax(3);
        $post['upperBound'] = "Max";
        $formContact->addField("lowerUpperBound", new Text(TRUE));
        $formContact->getField("lowerUpperBound")->setLengthMin(0);
        $formContact->getField("lowerUpperBound")->setLengthMax(3);
        $post['lowerUpperBound'] = "Max";
        $this->assertTrue($formContact->judge($post)->isPassed());
    }
}