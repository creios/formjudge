<?php
//
//namespace Creios\FormJudge;
//
//use Creios\FormJudge\Fields\Number;
//use Creios\FormJudge\Fields\Text;
//
//class PartialTests extends \PHPUnit_Framework_TestCase
//{
//
//    public function testText()
//    {
//        $post['text'] = 'text';
//        $form = new Form();
//        $form->addField('text', Text::createInstance());
//        $judgement = $form->judge($post);
//        $this->assertTrue($judgement->hasPassed());
//    }
//
//    public function testTextEmptyString()
//    {
//        $post['text'] = "";
//        $form = new Form();
//        $form->addField('text', Text::createInstance());
//        $judgement = $form->judge($post);
//        $this->assertTrue($judgement->hasPassed());
//
//        $post['text'] = "";
//        $form = new Form();
//        $form->addField('text', Text::createInstance(true));
//        $judgement = $form->judge($post);
//        $this->assertFalse($judgement->hasPassed());
//    }
//
//    public function testNumber()
//    {
//        $form = new Form();
//        $form->addField('numeric', Number::createInstance(True));
//
//        $post['numeric'] = '2';
//        $judgement = $form->judge($post);
//        $this->assertTrue($judgement->hasPassed());
//
//        $post['numeric'] = '-2';
//        $judgement = $form->judge($post);
//        $this->assertTrue($judgement->hasPassed());
//
//        $post['numeric'] = 'notANumber';
//        $judgement = $form->judge($post);
//        $this->assertFalse($judgement->hasPassed());
//    }
//
//    public function testField2()
//    {
//        $formContact = new Form();
//        $formContact->addField('length', Number::createInstance(True));
//        $formContact->getField('length')->setLengthMinConstraint(0);
//        $formContact->getField('length')->setLengthMaxConstraint(5);
//    }
//
//    public function testMinMaxField()
//    {
//        $formContact = new Form();
//        //range
//        $formContact->addField('lowerBound', Number::createInstance(True));
//        $formContact->getField('lowerBound')->setMinConstraint(0);
//        $post['lowerBound'] = 0;
//        $formContact->addField('upperBound', Number::createInstance(True));
//        $formContact->getField('upperBound')->setMaxConstraint(2);
//        $post['upperBound'] = 1;
//        $formContact->addField('lowerUpperBound', Number::createInstance(True));
//        $formContact->getField('lowerUpperBound')->setMinConstraint(0);
//        $formContact->getField('lowerUpperBound')->setMaxConstraint(2);
//        $post['lowerUpperBound'] = 1;
//        $judgement = $formContact->judge($post);
//        $this->assertTrue($judgement->hasPassed());
//        $this->assertFalse($judgement->getFieldJudgement('lowerBound')->isOutOfRange());
//    }
//
//    public function testLengthMinLengthMaxField()
//    {
//        $formContact = new Form();
//        //range
//        $formContact->addField('lowerBound', Text::createInstance(True));
//        $formContact->getField('lowerBound')->setLengthMinConstraint(0);
//        $post['lowerBound'] = 'Max';
//        $formContact->addField('upperBound', Text::createInstance(True));
//        $formContact->getField('upperBound')->setLengthMaxConstraint(3);
//        $post['upperBound'] = 'Max';
//        $formContact->addField('lowerUpperBound', Text::createInstance(True));
//        $formContact->getField('lowerUpperBound')->setLengthMinConstraint(0);
//        $formContact->getField('lowerUpperBound')->setLengthMaxConstraint(3);
//        $post['lowerUpperBound'] = 'Max';
//        $this->assertTrue($formContact->judge($post)->hasPassed());
//    }
//}