<?php

namespace CEWP\Modules\Books;

use CEWP\AbstractModule;
use CEWP\Modules\Books\PostTypes\BookPostType;

class Books extends AbstractModule {
    public function __construct(){
        $this->addPostType(new BookPostType());
    }
}