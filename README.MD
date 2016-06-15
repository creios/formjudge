# FormJudge - I am the law

[![Build Status](https://travis-ci.org/creios/formjudge.svg?branch=master)](https://travis-ci.org/creios/formjudge)
[![Coverage Status](https://coveralls.io/repos/creios/formjudge/badge.svg?branch=master&service=github)](https://coveralls.io/github/creios/formjudge?branch=master)
[![GitHub license](https://img.shields.io/github/license/creios/formjudge.svg)]()

**FormJudge** is a validation library for form input data.

```php
<?php

use Creios\FormJudge\Formular;
use Creios\FormJudge\Fields\Numeric;
use Creios\FormJudge\Fields\Text;
use Creios\FormJudge\Fields\Email;

$formContact = new Formular();
$formContact->addField("message", new Text(true));
$formContact->addField("gender", new Text(true));
$formContact->getField("gender")->addOption("M");
$formContact->getField("gender")->addOption("F");
$formContact->addField('userId', new Numeric(true));
$formContact->addField("firstname", new Text(true));
$formContact->addField("lastname", new Text(true));
$formContact->addField('email', new Email(true));

$post['message'] = "Hello World!";
$post['gender'] = "M";
$post['userId'] = "1";
$post['firstname'] = "john";
$post['lastname'] = "doe";
$post['email'] = "john@doe.tld";

$judgement= $formContact->judge($post);

if($judgement->isPassed()){
    echo "Formular has passed validation.";
}else{
    echo "Formular didn't pass validation.";
}
```

## Install

You can use [composer](https://getcomposer.org/) to download and install formjudge. Visit formjudge on [packagist](https://packagist.org/packages/creios/formjudge).

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

