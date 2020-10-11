<?php
/**
 * @package cewp
 */
/**
Plugin Name: CEWP
Plugin URI: https://xy.z/
Description: my first plugin <strong>-</strong>
Version:0.0.1
Author: Christoph Ehlers
Author URI: https://github.com/cehlers88
Text Domain: cewp
 */
use CEWP\CEWP;

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
} else {
    throw new Exception('You need to run "composer update" in the following directory: ' . __DIR__ . '.');
}

$plugin = new CEWP();
$plugin->loadPlugins(__DIR__.'/modules');

$plugin->registerAdminScripts();

register_activation_hook(__FILE__, ['plugin','activate']);

register_deactivation_hook(__FILE__,['plugin','deactivate']);

register_uninstall_hook(__FILE__,['plugin','uninstall']);
