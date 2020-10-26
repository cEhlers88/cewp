<?php

namespace CEWP\Modules\Git;

use CEWP\AbstractModule;
use CEWP\CEWP;
use CEWP\ModuleInterface;
use CEWP\Modules\Git\PostTypes\RepositoryPostType;
use CMB2;

class Git extends AbstractModule {
    private string $prefix = 'git_';

    public function __construct(){
        $this->addPostType(new RepositoryPostType());

        $this->addCmb2Box([
            'id' => $this->prefix . 'repo_metabox',
            'title' => 'Details',
            'object_types' => [$this->prefix.'repository'],
            'context' => 'normal',
            'priority' => 'low',
            'fields'=>[
                [
                    'name' => 'URL',
                    'id' => $this->prefix . 'baseUrl',
                    'type' => 'text_url',
                    'attributes' => ['required' => 'required']
                ],
                [
                    'name' => 'Kurzbeschreibung',
                    'id' => $this->prefix . 'shortDescription',
                    'type' => 'text_medium',
                    'attributes' => ['required' => 'required']
                ]
            ]
        ]);
    }

    public function init(CEWP $CEWP): ModuleInterface
    {
        $CEWP->AdminSiteRules()->addColumn($this->prefix.RepositoryPostType::KEY_SUFFIX,'URL', function (int $post_id) {
            $projectURL = get_post_meta($post_id, $this->prefix . 'baseUrl', true);
            if($projectURL==='') {
                return null;
            }
            echo sprintf('<a href="%1$s" target="_blank">%1$s</a>',$projectURL);

        });

        return parent::init($CEWP);
    }
}