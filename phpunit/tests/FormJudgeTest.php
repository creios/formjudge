<?php

namespace Creios\FormJudge;

use Creios\FormJudge\Factories\Factory;
use Creios\FormJudge\Fields\Date;
use Creios\FormJudge\Fields\DateTimeLocal;
use Creios\FormJudge\Fields\Email;
use Creios\FormJudge\Fields\Number;
use Creios\FormJudge\Fields\Tel;
use Creios\FormJudge\Fields\Text;
use Creios\FormJudge\Fields\Time;
use Creios\FormJudge\Fields\Url;

class FormJudgeTest extends \PHPUnit_Framework_TestCase
{

    public function testNotValidForm()
    {
        $formContact = new Form();
        $formContact->addField("supportArea", new Number(TRUE));
        $this->assertTrue($formContact->getField("supportArea")->hasMandatoryConstraint());
        $judgement = $formContact->judge(array());
        $this->assertFalse($judgement->hasPassed());

    }

    public function testNotValidForm2()
    {
        $form = new Form();
        $form->addLevel("USER", new Level());
        $form->getLevel("USER")->addField("id", new Number(TRUE));
        $form->addLevel("EMPTY", new Level());
        $form->getLevel("EMPTY")->addField("empty", new Text(TRUE));
        $judgement = $form->judge(array("USER" => array("id" => "not a number")));
        $this->assertFalse($judgement->hasPassed());
    }

    public function testPasswordConfirmation()
    {
        $oFieldsForm1 = new Form();
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
        $formContact = new Form();
        $formContact->addField("supportArea", new Number(TRUE));
        $formContact->getField("supportArea")->addOptionConstraint("0");
        $formContact->getField("supportArea")->addOptionConstraint("1");
        $formContact->addField("message", new Text(TRUE));
        $formContact->addField("gender", new Text(TRUE));
        $formContact->getField("gender")->addOptionConstraint("M");
        $formContact->getField("gender")->addOptionConstraint("F");
        $formContact->addField("firstname", new Text(TRUE));
        $formContact->addField("lastName", new Text(TRUE));
        $formContact->addField('email', new Email(TRUE));
        $formContact->addField('company', new Number(TRUE));

        $this->assertEquals([0, 1], $formContact->getField("supportArea")->getOptionsConstraint());
        $this->assertEquals(["M", "F"], $formContact->getField("gender")->getOptionsConstraint());

        $post['supportArea'] = "1";
        $post['message'] = "test";
        $post['gender'] = "M";
        $post['firstname'] = "Ben";
        $post['lastName'] = "Limper";
        $post['email'] = "ben@limper.tld";
        $post['company'] = "1";

        $judgement = $formContact->judge($post);
        $this->assertTrue($judgement->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement('supportArea')->isNotInOptions());
        $this->assertEquals(["0", "1"], $judgement->getFieldJudgement('supportArea')->getOptionsConstraint());
        $this->assertFalse($judgement->getFieldJudgement('supportArea')->isNotInPost());

        $generator = $formContact->getGenerator();
        $this->assertEquals('type="number" required', $generator->getField("supportArea")->generate());
    }

    public function testField()
    {
        $formContact = new Form();
        //range
        $formContact->addField("fromTo", new Number(TRUE));
        $formContact->getField("fromTo")->setMinConstraint(0);
        $formContact->getField("fromTo")->setMaxConstraint(10);
        //length
        $formContact->addField("length", new Number(TRUE));
        $formContact->getField("length")->setLengthMinConstraint(0);
        $formContact->getField("length")->setLengthMaxConstraint(5);

        $this->assertEquals(0, $formContact->getField('fromTo')->getMinConstraint());
        $this->assertEquals(10, $formContact->getField('fromTo')->getMaxConstraint());
        $this->assertEquals(0, $formContact->getField('length')->getLengthMinConstraint());
        $this->assertEquals(5, $formContact->getField('length')->getLengthMaxConstraint());

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

    public function testJson()
    {
        $formContact = new Form();
        $formContact->addField("supportArea", new Number(TRUE));
        $formContact->addLevel("newLevel");
        $formContact->getLevel("newLevel")->addField("test", new Email())->setRequiredConstraint(TRUE);
        $formContact->getLevel("newLevel")->addLevel("secondLevel")->addField("test", new Email());
    }

    public function testBoolean()
    {
        $post['true'] = "true";
        $post['false'] = "false";
        $form = new Form();
        $form->addField('true', Factory::createBooleanText(True));
        $form->addField('false', Factory::createBooleanText(True));
        $this->assertTrue($form->judge($post)->hasPassed());
    }

    public function testDate()
    {
        $post['date'] = "12.05.1987";
        $form = new Form();
        $form->addField('date', new Date(TRUE));
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());
        $post['date'] = "425.544.1987";
        $judgement = $form->judge($post);
        $this->assertFalse($judgement->hasPassed());
    }

    public function testDatetimeLocal()
    {
        $form = new Form();
        $form->addField('date', new DateTimeLocal(TRUE));

        $post['date'] = "2015-10-15T15:15:15";
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());

        $post['date'] = "2015-10-15Tb5:15:15";
        $judgement = $form->judge($post);
        $this->assertFalse($judgement->hasPassed());

        $post['date'] = "2015-10-63T15:15:15";
        $judgement = $form->judge($post);
        $this->assertFalse($judgement->hasPassed());
    }

    public function testEmail()
    {
        $post = ['user'];
        $post['user']['email'] = "tegeler@creios.net";
        $form = new Form();
        $form->addLevel('user', new Level());
        $form->getLevel('user')->addField('email', new Email(TRUE));

        $this->assertEquals('^[A-Za-z0-9]+([-_\.]?[A-Za-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}$', $form->getLevel('user')->getField('email')->getPatternConstraint());
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());
        $this->assertEquals('^[A-Za-z0-9]+([-_\.]?[A-Za-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}$', $judgement->getFieldListJudgement('user')->getFieldJudgement('email')->getPatternConstraint());
    }

    public function testFax()
    {
        $post['fax'] = "+49 123 12-123";
        $form = new Form();
        $form->addField('fax', new Tel(true));
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());
    }

    public function testMobile()
    {
        $post['mobile'] = "+49 923 1212";
        $form = new Form();
        $form->addField('mobile', new Tel(true));
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());
    }

    public function testTel()
    {
        $post['tel'] = "+49 923 12423-344";
        $form = new Form();
        $form->addField('tel', new Tel());
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());
    }

    public function testTelFailed()
    {
        $post['tel'] = "not a number";
        $form = new Form();
        $form->addField('tel', new Tel(true));
        $judgement = $form->judge($post);
        $this->assertFalse($judgement->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement("tel")->isSyntaxError());
        $this->assertTrue($judgement->getFieldJudgement("tel")->hasMandatoryConstraint());
        $this->assertEquals("not a number", $judgement->getFieldJudgement("tel")->getValue());
        $this->assertFalse($judgement->getFieldJudgement("tel")->isEmpty());
    }

    public function testText()
    {
        $post['text'] = "text";
        $form = new Form();
        $form->addField('text', new Text());
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());
    }

    public function testTextEmptyString()
    {
        $post['text'] = "";
        $form = new Form();
        $form->addField('text', new Text());
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());

        $post['text'] = "";
        $form = new Form();
        $form->addField('text', new Text(true));
        $judgement = $form->judge($post);
        $this->assertFalse($judgement->hasPassed());
    }

    public function testTime()
    {
        $post['time'] = "11:45";
        $form = new Form();
        $form->addField('time', new Time());
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());
    }

    public function testUrl()
    {
        $post['url'] = "example.de";
        $form = new Form();
        $form->addField('url', new Url());
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());
    }

    public function testNumber()
    {
        $post['numeric'] = "2";
        $form = new Form();
        $form->addField('numeric', new Number(TRUE));
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());
    }

    public function testField2()
    {
        $formContact = new Form();
        $formContact->addField("length", new Number(TRUE));
        $formContact->getField("length")->setLengthMinConstraint(0);
        $formContact->getField("length")->setLengthMaxConstraint(5);
    }

    public function testMinMaxField()
    {
        $formContact = new Form();
        //range
        $formContact->addField("lowerBound", new Number(TRUE));
        $formContact->getField("lowerBound")->setMinConstraint(0);
        $post['lowerBound'] = 0;
        $formContact->addField("upperBound", new Number(TRUE));
        $formContact->getField("upperBound")->setMaxConstraint(2);
        $post['upperBound'] = 1;
        $formContact->addField("lowerUpperBound", new Number(TRUE));
        $formContact->getField("lowerUpperBound")->setMinConstraint(0);
        $formContact->getField("lowerUpperBound")->setMaxConstraint(2);
        $post['lowerUpperBound'] = 1;
        $judgement = $formContact->judge($post);
        $this->assertTrue($judgement->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement("lowerBound")->isOutOfRange());
    }

    public function testLengthMinLengthMaxField()
    {
        $formContact = new Form();
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
