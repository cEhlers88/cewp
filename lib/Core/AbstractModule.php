<?php

namespace CEWP\Core;

use CMB2;

abstract class AbstractModule implements ModuleInterface
{
    /**
     * @var PostType[]
     */
    private array $postTypes = [];

    private array $cmb2Boxes = [];

    public function addPostType(PostType $postType):AbstractModule {
        $this->postTypes[] = $postType;
        return $this;
    }

    public function addCmb2Box(array $CMB2): ModuleInterface {
        $this->cmb2Boxes[] = $CMB2;
        return $this;
    }

    public function getPostTypes(): array {
        return $this->postTypes;
    }

    public function createCmb2Boxes(): array {
        return array_map(function($args){
            return new_cmb2_box($args);
        },$this->cmb2Boxes);
    }

    public function init(CEWP $CEWP): ModuleInterface {
        return $this;
    }
}