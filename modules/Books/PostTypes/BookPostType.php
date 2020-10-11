<?php

namespace CEWP\Modules\Books\PostTypes;

use CEWP\PostType;

class BookPostType extends PostType
{
    public function __construct(){
        $this
            ->setKey('book')
            ->setLabel("Bücher")
            ->setIsPublic(true);
    }
}