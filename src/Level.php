<?php

namespace Creios\FormJudge;

/**
 * Class Level
 * @package FormJudge
 */
class Level extends FieldList
{

    /** @var Level */
    private $parent;

    /**
     * @param $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

}
