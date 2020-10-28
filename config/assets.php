<?php

namespace CEWP;

use CEWP\AssetManagement\AssetCollection;

add_action('cewp/assets', function (AssetCollection $assets): void {
    $assets
        ->add('admin.js')
        ->environment('admin');

    $assets
        ->add('frontend.css')
        ->condition(is_home());
});