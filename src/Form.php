<?php

namespace Creios\FormJudge;

use Creios\FormJudge\Court\FieldListJudgement;
use Creios\FormJudge\Court\Judge;

/**
 * Class Form
 * @package FormJudge
 */
class Form extends FieldList
{

    /**
     * @param array $post
     * @return FieldListJudgement
     * @throws \LogicException
     */
    public function judge(array $post)
    {

        return Judge::judge($this, $post);
    }

}
