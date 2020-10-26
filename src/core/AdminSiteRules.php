<?php

namespace CEWP\core;

class AdminSiteRules {
    private $rulesColumnsAdd = [];

    public function addColumn(string $postType, string $columnName, callable $valueCallback){
        if(!isset($this->rulesColumnsAdd[$postType])){$this->rulesColumnsAdd[$postType] = [];}
        $this->rulesColumnsAdd[$postType][$columnName] = $valueCallback;
    }

    public function addRule(string $ruleType){
        /*
         *     Admin::remove_column('event', 'date');

    Admin::add_column('event', 'Ort', function (int $post_id) {
        echo get_post_meta($post_id, 'sp_event_location', true);
    });

    Admin::add_column('event', 'Datum', function (int $post_id) {
        echo date('m. F Y', get_post_meta($post_id, 'sp_event_date', true));
    });

    Admin::add_column('event', 'Terminanfragen', function (int $post_id) {
        echo get_post_meta($post_id, 'sp_event_appointments', true);
    });

    Admin::sort_column('event', 'Event Datum', 'sp_event_date', true);
         */
    }

    public function execute(){
        foreach ($this->rulesColumnsAdd as $postTypeName => $rule){
            add_filter('manage_edit-'.$postTypeName.'_columns',function($columns) use ($rule) {
                foreach ($rule as $columnName => $callback){
                    $columns[$columnName] = $columnName;
                }
                return $columns;
            });

            add_action ('manage_'.$postTypeName.'_posts_custom_column',function($column) use ($postTypeName){
                global $post;
                return $this->rulesColumnsAdd[$postTypeName][$column]($post->ID);
            });
        }
    }
}