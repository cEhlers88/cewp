<?php

namespace CEWP\Modules\Books\PostTypes;

use CEWP\PostType;

class BookPostType extends PostType
{
    public function __construct(){
        $this
            ->setKey('book')
            ->setLabelMenuName("Bücher")
            ->setLabelAllItems('Alle Bücher')
            ->setLabelAddNewItem('Ein neues Buch erstellen')
            ->setLabelAddNew('Buch erstellen')
            ->setIsPublic(true)
        ;
    }
}