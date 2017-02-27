<?php

namespace Creios\FormJudge;

use Creios\FormJudge\Factories\Factory;
use Creios\FormJudge\Fields\Color;
use Creios\FormJudge\Fields\Date;
use Creios\FormJudge\Fields\DateTimeLocal;
use Creios\FormJudge\Fields\Email;
use Creios\FormJudge\Fields\Month;
use Creios\FormJudge\Fields\Number;
use Creios\FormJudge\Fields\Range;
use Creios\FormJudge\Fields\Tel;
use Creios\FormJudge\Fields\Text;
use Creios\FormJudge\Fields\TextArea;
use Creios\FormJudge\Fields\Time;
use Creios\FormJudge\Fields\Url;
use Creios\FormJudge\Fields\Week;

class FormJudgeTest extends \PHPUnit_Framework_TestCase
{

    /** @var Form */
    private $formContact;

    public function setUp()
    {
        // configure FormJudge
        $this->formContact = new Form();
        $this->formContact->addField('age', Factory::createInt(True));
        $this->formContact->addField('admin', Factory::createBooleanText(True));
        $this->formContact->addField('bornDate', Date::createInstance(True));
        $this->formContact->addField('bornMonth', Month::createInstance(True));
        $this->formContact->addField('bornWeek', Week::createInstance(True));
        $this->formContact->addField('companyId', Number::createInstance(True));
        $this->formContact->addField('email', Email::createInstance(True));
        $this->formContact->addField('excelSkill', Range::createInstance(True)->setMinConstraint(0)->setMaxConstraint(1));
        $this->formContact->addField('favoriteColor', Color::createInstance(True));
        $this->formContact->addField('fax', Tel::createInstance()->setPatternConstraint('^\+?[0-9]+$'));
        $this->formContact->addField('firstname', Text::createInstance(True)->setLengthMinConstraint(3)->setLengthMaxConstraint(10));
        $this->formContact->addField('gender', Text::createInstance(True)->addOptionConstraint('F')->addOptionConstraint('M'));
        $this->formContact->addField('lastName', Text::createInstance(True)->setLengthMinConstraint(3)->setLengthMaxConstraint(10));
        $this->formContact->addField('message', TextArea::createInstance(True)->setLengthMaxConstraint(500));
        $this->formContact->addField('mobile', Tel::createInstance(True)->setPatternConstraint('^\+?[0-9]+$'));
        $this->formContact->addField('now', DateTimeLocal::createInstance(True));
        $this->formContact->addField('tel', Tel::createInstance()->setPatternConstraint('^\+?[0-9]+$'));
        $this->formContact->addField('time', Time::createInstance());
        $this->formContact->addField('url', Url::createInstance(True));
        $this->formContact->addLevel('password');
        // todo validation depends on ordering
        $this->formContact->getLevel('password')->addField('new', Text::createInstance(True));
        $this->formContact->getLevel('password')->addField('confirm', Text::createInstance(True));
        $this->formContact->getLevel('password')->getField('confirm')->setEqualToConstraint($this->formContact->getLevel('password')->getField('new'));
    }

    public function testConfiguration()
    {
        $this->assertSame(0, $this->formContact->getField('excelSkill')->getMinConstraint());
        $this->assertSame(1, $this->formContact->getField('excelSkill')->getMaxConstraint());
        $this->assertSame(['F', 'M'], $this->formContact->getField('gender')->getOptionsConstraint());
        $this->assertSame(10, $this->formContact->getField('firstname')->getLengthMaxConstraint());
        $this->assertSame(10, $this->formContact->getField('lastName')->getLengthMaxConstraint());
        $this->assertSame(500, $this->formContact->getField('message')->getLengthMaxConstraint());
        // todo complete
    }

    public function testGenerator()
    {
        $generator = $this->formContact->getGenerator();
        $this->assertEquals('type="number" min="0" max="2147483648" pattern="-?[0-9]+" required', $generator->getField('age')->generate());
        $this->assertEquals('type="text" pattern="^(0|1|TRUE|FALSE|true|false|ON|OFF|on|off)$" required', $generator->getField('admin')->generate());
        $this->assertEquals('type="text" minlength="3" maxlength="10" required', $generator->getField('firstname')->generate());
        $this->assertEquals('type="text" minlength="3" maxlength="10" required', $generator->getField('lastName')->generate());
        $this->assertEquals('type="tel" pattern="^\+?[0-9]+$"', $generator->getField('fax')->generate());
        $this->assertEquals('maxlength="500" required', $generator->getField('message')->generate());
        // todo complete
    }

    public function testValidContactData()
    {
        // crate post array
        $post['age'] = '29';
        $post['bornDate'] = '1987-01-01';
        $post['bornMonth'] = '1987-01';
        $post['bornWeek'] = '1987-W01';
        $post['companyId'] = '13292355';
        $post['email'] = 'ben@limper.tld';
        $post['excelSkill'] = '0.5';
        $post['favoriteColor'] = '#343521';
        $post['fax'] = '+4912312123';
        $post['firstname'] = 'Ben';
        $post['gender'] = 'M';
        $post['lastName'] = 'Limper';
        $post['message'] = 'test';
        $post['mobile'] = '+499231212';
        $post['now'] = '2015-10-15T15:15:15';
        $post['password']['confirm'] = 'test';
        $post['password']['new'] = 'test';
        $post['tel'] = '+4992312423344';
        $post['time'] = '11:45';
        $post['admin'] = 'true';
        $post['url'] = 'example.de';

        // judge post array against configuration
        $judgement = $this->formContact->judge($post);

        // test judgement
        $this->assertTrue($judgement->getFieldJudgement('age')->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement('admin')->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement('bornDate')->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement('bornMonth')->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement('bornWeek')->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement('companyId')->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement('email')->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement('excelSkill')->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement('favoriteColor')->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement('fax')->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement('firstname')->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement('gender')->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement('lastName')->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement('message')->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement('mobile')->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement('now')->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement('tel')->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement('time')->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement('admin')->hasPassed());
        $this->assertTrue($judgement->getFieldJudgement('url')->hasPassed());
        $this->assertTrue($judgement->getFieldListJudgement('password')->hasPassed());
    }

    public function testInvalidContactData()
    {
        // crate post array
        $post['age'] = 'twentyNine';
        $post['admin'] = 'yesIamAnAdmin';
        $post['bornDate'] = '01-01-1987';
        $post['bornMonth'] = '01-1987';
        $post['bornWeek'] = '1987-w01';
        $post['companyId'] = 'c13-292-355';
        $post['email'] = 'jöhn.doe@example';
        $post['excelSkill'] = '11';
        $post['favoriteColor'] = 'black';
        $post['fax'] = '+49 123 12-123';
        $post['firstname'] = 'Maximilian Montgomery';
        $post['fromTo'] = 10;
        $post['gender'] = 1;
        $post['lastName'] = 'Emerson Lake and Palmer';
        $post['message'] = 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea';
        $post['mobile'] = '';
        $post['now'] = '2015-10-15 15:15:15';
        $post['password']['confirm'] = 'password';
        $post['password']['new'] = 'passwort';
        $post['tel'] = '+49 923 12423-344';
        $post['time'] = '25:45';
        $post['url'] = 'example:com';

        // judge post array against configuration
        $judgement = $this->formContact->judge($post);

        // test judgement
        $this->assertFalse($judgement->getFieldJudgement('age')->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement('admin')->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement('bornDate')->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement('bornMonth')->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement('bornWeek')->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement('companyId')->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement('email')->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement('excelSkill')->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement('favoriteColor')->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement('fax')->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement('firstname')->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement('gender')->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement('lastName')->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement('message')->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement('mobile')->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement('now')->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement('tel')->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement('time')->hasPassed());
        $this->assertFalse($judgement->getFieldJudgement('url')->hasPassed());
        $this->assertFalse($judgement->getFieldListJudgement('password')->hasPassed());
    }

    public function testJudgement()
    {
        $post = [];

        // judge post array against configuration
        $judgement = $this->formContact->judge($post);

        $this->assertNull($judgement->getFieldJudgement('admin')->getValue());
        $this->assertNull($judgement->getFieldJudgement('admin')->isEmpty());
        $this->assertNull($judgement->getFieldJudgement('admin')->isNotEqual());
        $this->assertNull($judgement->getFieldJudgement('admin')->isNotInOptions());
        $this->assertNull($judgement->getFieldJudgement('admin')->isNotPassedLength());
        $this->assertNull($judgement->getFieldJudgement('admin')->isOutOfRange());
        $this->assertNull($judgement->getFieldJudgement('admin')->isPatternError());
        $this->assertNull($judgement->getFieldJudgement('admin')->isTypeError());
        $this->assertNull($judgement->getFieldJudgement('age')->getValue());
        $this->assertNull($judgement->getFieldJudgement('age')->isEmpty());
        $this->assertNull($judgement->getFieldJudgement('age')->isNotEqual());
        $this->assertNull($judgement->getFieldJudgement('age')->isNotInOptions());
        $this->assertNull($judgement->getFieldJudgement('age')->isNotPassedLength());
        $this->assertNull($judgement->getFieldJudgement('age')->isOutOfRange());
        $this->assertNull($judgement->getFieldJudgement('age')->isPatternError());
        $this->assertNull($judgement->getFieldJudgement('age')->isTypeError());
        $this->assertNull($judgement->getFieldJudgement('bornDate')->getValue());
        $this->assertNull($judgement->getFieldJudgement('bornDate')->isEmpty());
        $this->assertNull($judgement->getFieldJudgement('bornDate')->isNotEqual());
        $this->assertNull($judgement->getFieldJudgement('bornDate')->isNotInOptions());
        $this->assertNull($judgement->getFieldJudgement('bornDate')->isNotPassedLength());
        $this->assertNull($judgement->getFieldJudgement('bornDate')->isOutOfRange());
        $this->assertNull($judgement->getFieldJudgement('bornDate')->isPatternError());
        $this->assertNull($judgement->getFieldJudgement('bornDate')->isTypeError());
        $this->assertNull($judgement->getFieldJudgement('bornMonth')->getValue());
        $this->assertNull($judgement->getFieldJudgement('bornMonth')->isEmpty());
        $this->assertNull($judgement->getFieldJudgement('bornMonth')->isNotEqual());
        $this->assertNull($judgement->getFieldJudgement('bornMonth')->isNotInOptions());
        $this->assertNull($judgement->getFieldJudgement('bornMonth')->isNotPassedLength());
        $this->assertNull($judgement->getFieldJudgement('bornMonth')->isOutOfRange());
        $this->assertNull($judgement->getFieldJudgement('bornMonth')->isPatternError());
        $this->assertNull($judgement->getFieldJudgement('bornMonth')->isTypeError());
        $this->assertNull($judgement->getFieldJudgement('bornWeek')->getValue());
        $this->assertNull($judgement->getFieldJudgement('bornWeek')->isEmpty());
        $this->assertNull($judgement->getFieldJudgement('bornWeek')->isNotEqual());
        $this->assertNull($judgement->getFieldJudgement('bornWeek')->isNotInOptions());
        $this->assertNull($judgement->getFieldJudgement('bornWeek')->isNotPassedLength());
        $this->assertNull($judgement->getFieldJudgement('bornWeek')->isOutOfRange());
        $this->assertNull($judgement->getFieldJudgement('bornWeek')->isPatternError());
        $this->assertNull($judgement->getFieldJudgement('bornWeek')->isTypeError());
        $this->assertNull($judgement->getFieldJudgement('companyId')->getValue());
        $this->assertNull($judgement->getFieldJudgement('companyId')->isEmpty());
        $this->assertNull($judgement->getFieldJudgement('companyId')->isNotEqual());
        $this->assertNull($judgement->getFieldJudgement('companyId')->isNotInOptions());
        $this->assertNull($judgement->getFieldJudgement('companyId')->isNotPassedLength());
        $this->assertNull($judgement->getFieldJudgement('companyId')->isOutOfRange());
        $this->assertNull($judgement->getFieldJudgement('companyId')->isPatternError());
        $this->assertNull($judgement->getFieldJudgement('companyId')->isTypeError());
        $this->assertNull($judgement->getFieldJudgement('email')->getValue());
        $this->assertNull($judgement->getFieldJudgement('email')->isEmpty());
        $this->assertNull($judgement->getFieldJudgement('email')->isNotEqual());
        $this->assertNull($judgement->getFieldJudgement('email')->isNotInOptions());
        $this->assertNull($judgement->getFieldJudgement('email')->isNotPassedLength());
        $this->assertNull($judgement->getFieldJudgement('email')->isOutOfRange());
        $this->assertNull($judgement->getFieldJudgement('email')->isPatternError());
        $this->assertNull($judgement->getFieldJudgement('email')->isTypeError());
        $this->assertNull($judgement->getFieldJudgement('excelSkill')->getValue());
        $this->assertNull($judgement->getFieldJudgement('excelSkill')->isEmpty());
        $this->assertNull($judgement->getFieldJudgement('excelSkill')->isNotEqual());
        $this->assertNull($judgement->getFieldJudgement('excelSkill')->isNotInOptions());
        $this->assertNull($judgement->getFieldJudgement('excelSkill')->isNotPassedLength());
        $this->assertNull($judgement->getFieldJudgement('excelSkill')->isOutOfRange());
        $this->assertNull($judgement->getFieldJudgement('excelSkill')->isPatternError());
        $this->assertNull($judgement->getFieldJudgement('excelSkill')->isTypeError());
        $this->assertNull($judgement->getFieldJudgement('favoriteColor')->getValue());
        $this->assertNull($judgement->getFieldJudgement('favoriteColor')->isEmpty());
        $this->assertNull($judgement->getFieldJudgement('favoriteColor')->isNotEqual());
        $this->assertNull($judgement->getFieldJudgement('favoriteColor')->isNotInOptions());
        $this->assertNull($judgement->getFieldJudgement('favoriteColor')->isNotPassedLength());
        $this->assertNull($judgement->getFieldJudgement('favoriteColor')->isOutOfRange());
        $this->assertNull($judgement->getFieldJudgement('favoriteColor')->isPatternError());
        $this->assertNull($judgement->getFieldJudgement('favoriteColor')->isTypeError());
        $this->assertNull($judgement->getFieldJudgement('fax')->getValue());
        $this->assertNull($judgement->getFieldJudgement('fax')->isEmpty());
        $this->assertNull($judgement->getFieldJudgement('fax')->isNotEqual());
        $this->assertNull($judgement->getFieldJudgement('fax')->isNotInOptions());
        $this->assertNull($judgement->getFieldJudgement('fax')->isNotPassedLength());
        $this->assertNull($judgement->getFieldJudgement('fax')->isOutOfRange());
        $this->assertNull($judgement->getFieldJudgement('fax')->isPatternError());
        $this->assertNull($judgement->getFieldJudgement('fax')->isTypeError());
        $this->assertNull($judgement->getFieldJudgement('firstname')->getValue());
        $this->assertNull($judgement->getFieldJudgement('firstname')->isEmpty());
        $this->assertNull($judgement->getFieldJudgement('firstname')->isNotEqual());
        $this->assertNull($judgement->getFieldJudgement('firstname')->isNotInOptions());
        $this->assertNull($judgement->getFieldJudgement('firstname')->isNotPassedLength());
        $this->assertNull($judgement->getFieldJudgement('firstname')->isOutOfRange());
        $this->assertNull($judgement->getFieldJudgement('firstname')->isPatternError());
        $this->assertNull($judgement->getFieldJudgement('firstname')->isTypeError());
        $this->assertNull($judgement->getFieldJudgement('gender')->getValue());
        $this->assertNull($judgement->getFieldJudgement('gender')->isEmpty());
        $this->assertNull($judgement->getFieldJudgement('gender')->isNotEqual());
        $this->assertNull($judgement->getFieldJudgement('gender')->isNotInOptions());
        $this->assertNull($judgement->getFieldJudgement('gender')->isNotPassedLength());
        $this->assertNull($judgement->getFieldJudgement('gender')->isOutOfRange());
        $this->assertNull($judgement->getFieldJudgement('gender')->isPatternError());
        $this->assertNull($judgement->getFieldJudgement('gender')->isTypeError());
        $this->assertNull($judgement->getFieldJudgement('lastName')->getValue());
        $this->assertNull($judgement->getFieldJudgement('lastName')->isEmpty());
        $this->assertNull($judgement->getFieldJudgement('lastName')->isNotEqual());
        $this->assertNull($judgement->getFieldJudgement('lastName')->isNotInOptions());
        $this->assertNull($judgement->getFieldJudgement('lastName')->isNotPassedLength());
        $this->assertNull($judgement->getFieldJudgement('lastName')->isOutOfRange());
        $this->assertNull($judgement->getFieldJudgement('lastName')->isPatternError());
        $this->assertNull($judgement->getFieldJudgement('lastName')->isTypeError());
        $this->assertNull($judgement->getFieldJudgement('message')->getValue());
        $this->assertNull($judgement->getFieldJudgement('message')->isEmpty());
        $this->assertNull($judgement->getFieldJudgement('message')->isNotEqual());
        $this->assertNull($judgement->getFieldJudgement('message')->isNotInOptions());
        $this->assertNull($judgement->getFieldJudgement('message')->isNotPassedLength());
        $this->assertNull($judgement->getFieldJudgement('message')->isOutOfRange());
        $this->assertNull($judgement->getFieldJudgement('message')->isPatternError());
        $this->assertNull($judgement->getFieldJudgement('message')->isTypeError());
        $this->assertNull($judgement->getFieldJudgement('mobile')->getValue());
        $this->assertNull($judgement->getFieldJudgement('mobile')->isEmpty());
        $this->assertNull($judgement->getFieldJudgement('mobile')->isNotEqual());
        $this->assertNull($judgement->getFieldJudgement('mobile')->isNotInOptions());
        $this->assertNull($judgement->getFieldJudgement('mobile')->isNotPassedLength());
        $this->assertNull($judgement->getFieldJudgement('mobile')->isOutOfRange());
        $this->assertNull($judgement->getFieldJudgement('mobile')->isPatternError());
        $this->assertNull($judgement->getFieldJudgement('mobile')->isTypeError());
        $this->assertNull($judgement->getFieldJudgement('now')->getValue());
        $this->assertNull($judgement->getFieldJudgement('now')->isEmpty());
        $this->assertNull($judgement->getFieldJudgement('now')->isNotEqual());
        $this->assertNull($judgement->getFieldJudgement('now')->isNotInOptions());
        $this->assertNull($judgement->getFieldJudgement('now')->isNotPassedLength());
        $this->assertNull($judgement->getFieldJudgement('now')->isOutOfRange());
        $this->assertNull($judgement->getFieldJudgement('now')->isPatternError());
        $this->assertNull($judgement->getFieldJudgement('now')->isTypeError());
        $this->assertNull($judgement->getFieldJudgement('tel')->getValue());
        $this->assertNull($judgement->getFieldJudgement('tel')->isEmpty());
        $this->assertNull($judgement->getFieldJudgement('tel')->isNotEqual());
        $this->assertNull($judgement->getFieldJudgement('tel')->isNotInOptions());
        $this->assertNull($judgement->getFieldJudgement('tel')->isNotPassedLength());
        $this->assertNull($judgement->getFieldJudgement('tel')->isOutOfRange());
        $this->assertNull($judgement->getFieldJudgement('tel')->isPatternError());
        $this->assertNull($judgement->getFieldJudgement('tel')->isTypeError());
        $this->assertNull($judgement->getFieldJudgement('time')->getValue());
        $this->assertNull($judgement->getFieldJudgement('time')->isEmpty());
        $this->assertNull($judgement->getFieldJudgement('time')->isNotEqual());
        $this->assertNull($judgement->getFieldJudgement('time')->isNotInOptions());
        $this->assertNull($judgement->getFieldJudgement('time')->isNotPassedLength());
        $this->assertNull($judgement->getFieldJudgement('time')->isOutOfRange());
        $this->assertNull($judgement->getFieldJudgement('time')->isPatternError());
        $this->assertNull($judgement->getFieldJudgement('time')->isTypeError());
        $this->assertNull($judgement->getFieldJudgement('url')->getValue());
        $this->assertNull($judgement->getFieldJudgement('url')->isEmpty());
        $this->assertNull($judgement->getFieldJudgement('url')->isNotEqual());
        $this->assertNull($judgement->getFieldJudgement('url')->isNotInOptions());
        $this->assertNull($judgement->getFieldJudgement('url')->isNotPassedLength());
        $this->assertNull($judgement->getFieldJudgement('url')->isOutOfRange());
        $this->assertNull($judgement->getFieldJudgement('url')->isPatternError());
        $this->assertNull($judgement->getFieldJudgement('url')->isTypeError());
        $this->assertTrue($judgement->getFieldJudgement('admin')->isNotInPost());
        $this->assertTrue($judgement->getFieldJudgement('age')->isNotInPost());
        $this->assertTrue($judgement->getFieldJudgement('bornDate')->isNotInPost());
        $this->assertTrue($judgement->getFieldJudgement('bornMonth')->isNotInPost());
        $this->assertTrue($judgement->getFieldJudgement('bornWeek')->isNotInPost());
        $this->assertTrue($judgement->getFieldJudgement('companyId')->isNotInPost());
        $this->assertTrue($judgement->getFieldJudgement('email')->isNotInPost());
        $this->assertTrue($judgement->getFieldJudgement('excelSkill')->isNotInPost());
        $this->assertTrue($judgement->getFieldJudgement('favoriteColor')->isNotInPost());
        $this->assertTrue($judgement->getFieldJudgement('fax')->isNotInPost());
        $this->assertTrue($judgement->getFieldJudgement('firstname')->isNotInPost());
        $this->assertTrue($judgement->getFieldJudgement('gender')->isNotInPost());
        $this->assertTrue($judgement->getFieldJudgement('lastName')->isNotInPost());
        $this->assertTrue($judgement->getFieldJudgement('message')->isNotInPost());
        $this->assertTrue($judgement->getFieldJudgement('mobile')->isNotInPost());
        $this->assertTrue($judgement->getFieldJudgement('now')->isNotInPost());
        $this->assertTrue($judgement->getFieldJudgement('tel')->isNotInPost());
        $this->assertTrue($judgement->getFieldJudgement('time')->isNotInPost());
        $this->assertTrue($judgement->getFieldJudgement('url')->isNotInPost());
        $this->assertSame(0, $judgement->getFieldJudgement('excelSkill')->getMinConstraint());
        $this->assertSame(1, $judgement->getFieldJudgement('excelSkill')->getMaxConstraint());
        $this->assertSame(10, $judgement->getFieldJudgement('firstname')->getLengthMaxConstraint());
        $this->assertSame(10, $judgement->getFieldJudgement('lastName')->getLengthMaxConstraint());
        $this->assertSame(500, $judgement->getFieldJudgement('message')->getLengthMaxConstraint());
        // todo complete

        $this->assertFalse($judgement->hasPassed());

    }
}
