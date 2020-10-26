<?php

namespace CEWP\Modules\Git\PostTypes;

use CEWP\PostType;

class RepositoryPostType extends PostType
{
    private string $prefix = 'git_';

    public const KEY_SUFFIX = "repository";

    public function __construct(){
        $this
            ->setKey($this->prefix.self::KEY_SUFFIX)
            ->setLabelMenuName("Repositories")
            ->setLabelAllItems('Alle Repositories')
            ->setLabelAddNewItem('Ein neues Repository erstellen')
            ->setLabelAddNew('Repository erstellen')
            ->setIsPublic(true)
        ;
    }
}