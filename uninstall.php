<?php
/**
* Trigger the file when user uninstall the plugin
*/
// If uninstall is not called from WordPress, exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
  exit;
}

// Delete plugin options
// delete_option('my_plugin_option');

// Flush rewrite rules
flush_rewrite_rules();