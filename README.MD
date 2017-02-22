# FormJudge - I am the law

[![Build Status](https://travis-ci.org/creios/formjudge.svg?branch=master)](https://travis-ci.org/creios/formjudge)
[![Coverage Status](https://coveralls.io/repos/github/creios/formjudge/badge.svg?branch=master)](https://coveralls.io/github/creios/formjudge?branch=master)
[![GitHub license](https://img.shields.io/github/license/creios/formjudge.svg)]()

**FormJudge** is a validation library for submitted form data.

```php
<?php

use Creios\FormJudge\Form;
use Creios\FormJudge\Fields\Numeric;
use Creios\FormJudge\Fields\Text;
use Creios\FormJudge\Fields\Email;

$formContact = new Form();
//establish your constraints
$formContact->addField("message", new Text(true));
$formContact->addField("gender", new Text(true));
$formContact->getField("gender")->addOptionConstraint("M");
$formContact->getField("gender")->addOptionConstraint("F");
$formContact->addField('userId', new Numeric(true));
$formContact->addField("firstname", new Text(true));
$formContact->addField("lastname", new Text(true));
$formContact->addField('email', new Email(true));

var_dump($_POST);
/*
array(6) {
    'message' => string(12) "Hello World!"
    'gender' => string(1) "M"
    'userId' => string(1) "1"
    'firstname' => string(4) "john"
    'lastname' => string(3) "doe"
    'email' => string(12) "john@doe.tld"
}
*/

//judge on basis of your constraints
$judgement = $formContact->judge($_POST);

//evaluate the judgement
if($judgement->hasPassed()){
    echo "Form has passed validation.";
}else{
    echo "Form didn't pass validation.";
}
```

## Client-side validation

The focus of FormJudge is on server-side validation of submitted form data, but it can also help you with client-side validation. You can use the constraints, that you added to the input elements, to use HTML5 form attributes like `max`, `min`, `pattern` etc. which will be respected by modern browsers.

```php
<?php

use Creios\FormJudge\Form;
use Creios\FormJudge\Fields\Numeric;

$form = new Form();
$dayOfWeek = (new Numeric(true))->setMinConstraint(1)->setMaxConstraint(7);
$form->addField('dayOfWeek', $dayOfWeek);
?>

<input type="number" 
    min="<?= $form->getField('dayOfWeek')->getMinConstraint() ?>"
    max="<?= $form->getField('dayOfWeek')->getMaxConstraint() ?>"
    name="daysOfWeek">
```

Renders to:
```html
<input type="number"
    min="1"
    max="7"
    name="daysOfWeek">
```

## Install

You can use [composer](https://getcomposer.org/) to download and install FormJudge. Visit FormJudge on [packagist](https://packagist.org/packages/creios/formjudge).

### composer.json
```json
{
    "require": {
        "creios/formjudge": "^1.0.0"
    }
}
```

or

### comandline

```sh
composer require creios/formjudge
```

