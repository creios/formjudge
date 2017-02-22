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
        $formContact->addField("supportArea", Number::createInstance(True));
        $this->assertTrue($formContact->getField("supportArea")->getRequiredConstraint());
        $judgement = $formContact->judge(array());
        $this->assertFalse($judgement->hasPassed());

    }

    public function testNotValidForm2()
    {
        $form = new Form();
        $form->addLevel("USER", new Level());
        $form->getLevel("USER")->addField("id", Number::createInstance(True));
        $form->addLevel("EMPTY", new Level());
        $form->getLevel("EMPTY")->addField("empty", Text::createInstance(True));
        $judgement = $form->judge(array("USER" => array("id" => "not a number")));
        $this->assertFalse($judgement->hasPassed());
    }

    public function testPasswordConfirmation()
    {
        $oFieldsForm1 = new Form();
        $oFieldsForm1->addLevel('password', new Level());
        $oFieldsForm1->getLevel('password')->addField('new', Text::createInstance(True));
        $oFieldsForm1->getLevel('password')->addField('confirm', Text::createInstance(True));
        $oFieldsForm1->getLevel('password')->getField('confirm')->setEqualToConstraint($oFieldsForm1->getLevel('password')->getField('new'));
        $post['password']['new'] = "test";
        $post['password']['confirm'] = "test";
        $judgement = $oFieldsForm1->judge($post);
        $this->assertTrue($judgement->hasPassed());
    }

    public function testContactData()
    {
        $formContact = new Form();
        $formContact->addField("supportArea", Number::createInstance(True));
        $formContact->getField("supportArea")->addOptionConstraint("0");
        $formContact->getField("supportArea")->addOptionConstraint("1");
        $formContact->addField("message", Text::createInstance(True));
        $formContact->addField("gender", Text::createInstance(True));
        $formContact->getField("gender")->addOptionConstraint("M");
        $formContact->getField("gender")->addOptionConstraint("F");
        $formContact->addField("firstname", Text::createInstance(True));
        $formContact->addField("lastName", Text::createInstance(True));
        $formContact->addField('email', Email::createInstance(True));
        $formContact->addField('company', Number::createInstance(True));

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
        $formContact->addField("fromTo", Number::createInstance(True));
        $formContact->getField("fromTo")->setMinConstraint(0);
        $formContact->getField("fromTo")->setMaxConstraint(10);
        //length
        $formContact->addField("length", Number::createInstance(True));
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
        $formContact->addField("supportArea", Number::createInstance(True));
        $formContact->addLevel("newLevel");
        $formContact->getLevel("newLevel")->addField("test", Email::createInstance())->setRequiredConstraint(TRUE);
        $formContact->getLevel("newLevel")->addLevel("secondLevel")->addField("test", Email::createInstance());
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
        $post['date'] = "1987-05-12";
        $form = new Form();
        $form->addField('date', Date::createInstance(TRUE));
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());
        $post['date'] = "1987-425-544";
        $judgement = $form->judge($post);
        $this->assertFalse($judgement->hasPassed());
    }

    public function testDatetimeLocal()
    {
        $form = new Form();
        $form->addField('date', DateTimeLocal::createInstance(TRUE));

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
        $form->getLevel('user')->addField('email', Email::createInstance(True));

        $this->assertEquals('^[A-Za-z0-9]+([-_\.]?[A-Za-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}$', $form->getLevel('user')->getField('email')->getPatternConstraint());
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());
        $this->assertEquals('^[A-Za-z0-9]+([-_\.]?[A-Za-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}$', $judgement->getFieldListJudgement('user')->getFieldJudgement('email')->getPatternConstraint());
    }

    public function testFax()
    {
        $post['fax'] = "+49 123 12-123";
        $form = new Form();
        $form->addField('fax', Tel::createInstance(True));
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());
    }

    public function testMobile()
    {
        $post['mobile'] = "+49 923 1212";
        $form = new Form();
        $form->addField('mobile', Tel::createInstance(True));
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());
    }

    public function testTel()
    {
        $post['tel'] = "+49 923 12423-344";
        $form = new Form();
        $form->addField('tel', Tel::createInstance());
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());
    }

    public function testTelFailed()
    {
        $post['tel'] = "+49 12 3456 221";
        $form = new Form();
        $form->addField('tel', Tel::createInstance(true));
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement("tel")->isPatternError());
        $this->assertTrue($judgement->getFieldJudgement("tel")->getRequiredConstraint());
        $this->assertEquals("+49 12 3456 221", $judgement->getFieldJudgement("tel")->getValue());
        $this->assertFalse($judgement->getFieldJudgement("tel")->isEmpty());
    }

    public function testText()
    {
        $post['text'] = "text";
        $form = new Form();
        $form->addField('text', Text::createInstance());
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());
    }

    public function testTextEmptyString()
    {
        $post['text'] = "";
        $form = new Form();
        $form->addField('text', Text::createInstance());
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());

        $post['text'] = "";
        $form = new Form();
        $form->addField('text', Text::createInstance(true));
        $judgement = $form->judge($post);
        $this->assertFalse($judgement->hasPassed());
    }

    public function testTime()
    {
        $post['time'] = "11:45";
        $form = new Form();
        $form->addField('time', Time::createInstance());
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());
    }

    public function testUrl()
    {
        $post['url'] = "example.de";
        $form = new Form();
        $form->addField('url', Url::createInstance(True));
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());
    }

    public function testNumber()
    {
        $form = new Form();
        $form->addField('numeric', Number::createInstance(True));

        $post['numeric'] = "2";
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());

        $post['numeric'] = "-2";
        $judgement = $form->judge($post);
        $this->assertTrue($judgement->hasPassed());

        $post['numeric'] = "notANumber";
        $judgement = $form->judge($post);
        $this->assertFalse($judgement->hasPassed());
    }

    public function testField2()
    {
        $formContact = new Form();
        $formContact->addField("length", Number::createInstance(True));
        $formContact->getField("length")->setLengthMinConstraint(0);
        $formContact->getField("length")->setLengthMaxConstraint(5);
    }

    public function testMinMaxField()
    {
        $formContact = new Form();
        //range
        $formContact->addField("lowerBound", Number::createInstance(True));
        $formContact->getField("lowerBound")->setMinConstraint(0);
        $post['lowerBound'] = 0;
        $formContact->addField("upperBound", Number::createInstance(True));
        $formContact->getField("upperBound")->setMaxConstraint(2);
        $post['upperBound'] = 1;
        $formContact->addField("lowerUpperBound", Number::createInstance(True));
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
        $formContact->addField("lowerBound", Text::createInstance(True));
        $formContact->getField("lowerBound")->setLengthMinConstraint(0);
        $post['lowerBound'] = "Max";
        $formContact->addField("upperBound", Text::createInstance(True));
        $formContact->getField("upperBound")->setLengthMaxConstraint(3);
        $post['upperBound'] = "Max";
        $formContact->addField("lowerUpperBound", Text::createInstance(True));
        $formContact->getField("lowerUpperBound")->setLengthMinConstraint(0);
        $formContact->getField("lowerUpperBound")->setLengthMaxConstraint(3);
        $post['lowerUpperBound'] = "Max";
        $this->assertTrue($formContact->judge($post)->hasPassed());
    }
}
