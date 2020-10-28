<?php

namespace CEWP;

use CMB2;

interface ModuleInterface
{
    /**
     * @return PostType[]
     */
    public function getPostTypes():array;

    public function addCmb2Box(array $CMB2): ModuleInterface;

    /**
     * @return CMB2[]
     */
    public function createCmb2Boxes():array;

    public function init(CEWP $CEWP):ModuleInterface;
}