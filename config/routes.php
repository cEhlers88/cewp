<?php

namespace CEWP;

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

add_action('cewp/routes', function (RoutingConfigurator $routes): void {
    $routes
        ->add('blog_show', [
            'en' => '/blog/{slug}/',
            'de' => '/de/blog/{slug}/'
        ])
        ->controller([BlogController::class, 'show']);
});