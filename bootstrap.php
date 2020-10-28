<?php

/**
 * @wordpress-plugin
 * Plugin Name: WordPress Plugin Foundation
 * Plugin URI: https://github.com/cEhlers88/cewp
 * Description: Foundation for advanced WordPress plugin development.
 * Version: 0.0.1
 * Author: Christoph Ehlers
 * GitHub Plugin URI: https://github.com/cEhlers88/cewp
 */

namespace CEWP;

use Exception;
use CEWP\AssetManagement\AssetManagement;
use CEWP\Core\WpPlugin;

// Do not access file directly.
if (!defined('ABSPATH')) {
    exit;
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
} else {
    throw new Exception('You need to run "composer update" in the following directory: ' . __DIR__ . '.');
}

$plugin = new WpPlugin();
$plugin
    ->setConfigFolder(__DIR__ . '/config')
    ->loadExtension((new AssetManagement())->setDistFolder('/dist'))
    ->loadPlugins(__DIR__ . '/src')
    ->init();

register_activation_hook(__FILE__, [$plugin, 'activate']);
register_deactivation_hook(__FILE__, [$plugin, 'deactivate']);