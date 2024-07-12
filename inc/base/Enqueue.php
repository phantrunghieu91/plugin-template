<?php
/**
 * @package JinsPlugin
 * Enqueue Scripts and Styles
 */
namespace jinsPlugin\inc\base;

use jinsPlugin\inc\base\BaseController;

class Enqueue extends BaseController
{
  public function register()
  {
    if (is_admin()) {
      add_action('admin_enqueue_scripts', array($this, 'enqueueAdminsScripts'));
    } else {
      add_action('wp_enqueue_scripts', array($this, 'enqueueFrontEndScripts'));
    }
  }

  public function enqueueAdminsScripts()
  {
  }

  public function enqueueFrontEndScripts()
  {
  }
}
