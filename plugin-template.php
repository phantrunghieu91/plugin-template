<?php
/**
 * Plugin Name: Plugin Template
 * Description: A simple plugin template.
 * Version: 1.0.0
 * Author: Trung Hieu "Jin" Phan
 * Author URI: https://github.com/phantrunghieu91
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
defined('ABSPATH') or die('Hey, you can\t access this file, you silly human!');

// Require once the Composer Autoload
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
  require_once dirname(__FILE__) . '/vendor/autoload.php';
}

// Activate and Deactivate the plugin
function activate_plugin(){
  inc\base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_plugin' );

function deactivate_plugin(){
  inc\base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_plugin' );

// Initialize all the core classes of the plugin
if (class_exists('inc\Init')) {
  inc\Init::register_services();
}