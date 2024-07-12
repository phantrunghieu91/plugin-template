<?php
/**
 * @package JinsPlugin
 */
namespace jinsPlugin\inc\base;

class Activate
{
  public static function activate(){
    flush_rewrite_rules();
    
    // Checks if the 'jins_plugin' option is set and initializes it with a default value if not.
    $default = array();
  }
}